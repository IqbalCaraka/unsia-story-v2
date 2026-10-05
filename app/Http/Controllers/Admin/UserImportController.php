<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prodi;
use App\Models\TahunAjar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\NamedRange;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class UserImportController extends Controller
{
    /** Jumlah baris di template yang sudah dipasangi dropdown. */
    protected const BARIS_TEMPLATE = 500;

    /** Batas baris yang diproses sekali impor. */
    protected const MAKS_BARIS = 2000;

    /** Kolom template, berurutan. */
    protected const KOLOM = [
        'nim' => 'NIM',
        'nama' => 'Nama Lengkap',
        'email' => 'Email (opsional)',
        'prodi' => 'Program Studi',
        'tahun_ajar' => 'Tahun Ajar',
        'password' => 'Password (opsional)',
    ];

    public function form()
    {
        return view('admin.users.import', [
            'prodiList' => Prodi::orderBy('nama_prodi')->get(),
            'tahunAjarList' => TahunAjar::orderByDesc('tahun_ajar')->orderBy('ganjil_genap')->get(),
        ]);
    }

    /**
     * Unduh template .xlsx dengan dropdown prodi & tahun ajar yang diambil dari database.
     */
    public function template()
    {
        $prodi = Prodi::orderBy('nama_prodi')->pluck('nama_prodi')->all();
        $tahunAjar = TahunAjar::orderByDesc('tahun_ajar')->orderBy('ganjil_genap')->get()
            ->map(fn ($ta) => $ta->label)->all();

        if (empty($tahunAjar)) {
            return redirect()->route('admin.tahun-ajar.index')
                ->with('error', 'Belum ada tahun ajar. Tambahkan minimal satu sebelum mengunduh template.');
        }

        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()->setTitle('Template Import Peserta');

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Peserta');

        $this->tulisHeader($sheet);
        $referensi = $this->buatSheetReferensi($spreadsheet, $prodi, $tahunAjar);
        $this->pasangDropdown($sheet, $spreadsheet, $referensi, $prodi, $tahunAjar);
        $this->tulisPetunjuk($spreadsheet, $prodi, $tahunAjar);

        $sheet->freezePane('A2');
        $spreadsheet->setActiveSheetIndexByName('Data Peserta');
        $sheet->setSelectedCell('A2');

        $nama = 'template-import-peserta-' . now()->format('Ymd') . '.xlsx';

        return response()->streamDownload(function () use ($spreadsheet) {
            (new Xlsx($spreadsheet))->save('php://output');
        }, $nama, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'no-store, no-cache',
        ]);
    }

    /**
     * Impor bersifat semua-atau-tidak: kalau ada satu baris yang salah,
     * tidak ada baris yang tersimpan dan seluruh error dilaporkan sekaligus.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv,txt|max:5120',
        ], [], ['file' => 'berkas']);

        try {
            $baris = $this->bacaBaris($request->file('file'));
        } catch (\Throwable $e) {
            return back()->with('error', 'Berkas tidak bisa dibaca: ' . $e->getMessage());
        }

        if (empty($baris)) {
            return back()->with('error', 'Berkas tidak berisi data. Pastikan baris pertama adalah header template.');
        }

        if (count($baris) > self::MAKS_BARIS) {
            return back()->with('error',
                'Maksimal ' . self::MAKS_BARIS . ' baris sekali impor, berkas Anda berisi ' . count($baris) . ' baris.');
        }

        [$siap, $galat] = $this->validasiBaris($baris);

        if ($galat) {
            return back()->with('error', 'Impor dibatalkan, tidak ada data yang tersimpan.')
                ->with('importErrors', $galat);
        }

        DB::transaction(fn () => User::insert($siap));

        return redirect()->route('admin.users.index', ['role' => 'mahasiswa'])
            ->with('success', count($siap) . ' peserta berhasil diimpor.');
    }

    /**
     * Ambil baris data dari berkas, dipetakan berdasarkan nama header
     * supaya urutan kolom yang tertukar tetap terbaca.
     */
    protected function bacaBaris($file): array
    {
        $reader = IOFactory::createReaderForFile($file->getRealPath());
        $reader->setReadDataOnly(true);
        $sheet = $reader->load($file->getRealPath())->getSheet(0);

        $rows = $sheet->toArray(null, true, false, false);

        if (empty($rows)) {
            return [];
        }

        $header = array_map(
            fn ($h) => $this->slugHeader((string) $h),
            array_shift($rows)
        );

        // Cocokkan header berkas dengan kunci kolom template.
        $peta = [];
        foreach (self::KOLOM as $kunci => $judul) {
            $posisi = array_search($this->slugHeader($judul), $header, true);

            if ($posisi === false) {
                $posisi = array_search($kunci, $header, true);
            }

            if ($posisi !== false) {
                $peta[$kunci] = $posisi;
            }
        }

        $hasil = [];
        foreach ($rows as $index => $row) {
            $data = [];
            foreach ($peta as $kunci => $posisi) {
                $data[$kunci] = trim((string) ($row[$posisi] ?? ''));
            }

            // Lewati baris kosong (template punya 500 baris siap isi).
            if (implode('', $data) === '') {
                continue;
            }

            $data['_baris'] = $index + 2; // +1 header, +1 karena Excel mulai dari 1
            $hasil[] = $data;
        }

        return $hasil;
    }

    /**
     * @return array{0: array<int, array<string, mixed>>, 1: array<int, string>}
     */
    protected function validasiBaris(array $baris): array
    {
        $prodi = Prodi::pluck('id', 'nama_prodi')
            ->mapWithKeys(fn ($id, $nama) => [mb_strtolower($nama) => $id]);

        $tahunAjar = TahunAjar::all()
            ->mapWithKeys(fn ($ta) => [mb_strtolower($ta->label) => $ta->id]);

        // Closure, bukan 'mb_strtolower' langsung: map() mengoper key sebagai argumen kedua,
        // dan key itu akan dibaca sebagai nama encoding.
        $kecilkan = fn ($teks) => mb_strtolower((string) $teks);

        $nimTerpakai = User::whereNotNull('nim')->pluck('nim')->map($kecilkan)->flip();
        $emailTerpakai = User::whereNotNull('email')->pluck('email')->map($kecilkan)->flip();

        $siap = [];
        $galat = [];
        $sekarang = now();

        foreach ($baris as $data) {
            $no = $data['_baris'];
            $pesan = [];

            $nim = $data['nim'] ?? '';
            $nama = $data['nama'] ?? '';
            $email = $data['email'] ?? '';
            $namaProdi = mb_strtolower($data['prodi'] ?? '');
            $labelTa = mb_strtolower($data['tahun_ajar'] ?? '');
            $password = $data['password'] ?? '';

            if ($nim === '') {
                $pesan[] = 'NIM wajib diisi';
            } elseif (mb_strlen($nim) > 20) {
                $pesan[] = 'NIM maksimal 20 karakter';
            } elseif ($nimTerpakai->has(mb_strtolower($nim))) {
                $pesan[] = "NIM {$nim} sudah terpakai";
            }

            if ($nama === '') {
                $pesan[] = 'Nama wajib diisi';
            }

            if ($email !== '') {
                if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $pesan[] = "Email {$email} tidak valid";
                } elseif ($emailTerpakai->has(mb_strtolower($email))) {
                    $pesan[] = "Email {$email} sudah terpakai";
                }
            }

            if ($namaProdi === '') {
                $pesan[] = 'Program studi wajib diisi';
            } elseif (! $prodi->has($namaProdi)) {
                $pesan[] = "Program studi \"{$data['prodi']}\" tidak dikenal";
            }

            if ($labelTa === '') {
                $pesan[] = 'Tahun ajar wajib diisi';
            } elseif (! $tahunAjar->has($labelTa)) {
                $pesan[] = "Tahun ajar \"{$data['tahun_ajar']}\" tidak dikenal";
            }

            if ($password !== '' && mb_strlen($password) < 8) {
                $pesan[] = 'Password minimal 8 karakter';
            }

            if ($pesan) {
                $galat[] = "Baris {$no}: " . implode('; ', $pesan);

                continue;
            }

            // Kunci duplikat di dalam berkas itu sendiri, bukan cuma terhadap database.
            $nimTerpakai->put(mb_strtolower($nim), true);

            if ($email !== '') {
                $emailTerpakai->put(mb_strtolower($email), true);
            }

            $siap[] = [
                'nim' => $nim,
                'nama' => $nama,
                'name' => $nama,
                'email' => $email !== '' ? $email : null,
                'prodi_id' => $prodi->get($namaProdi),
                'tahun_ajar_id' => $tahunAjar->get($labelTa),
                'role' => 'mahasiswa',
                // Password kosong memakai NIM sebagai password awal.
                'password' => Hash::make($password !== '' ? $password : $nim),
                'created_at' => $sekarang,
                'updated_at' => $sekarang,
            ];
        }

        return [$siap, $galat];
    }

    protected function slugHeader(string $teks): string
    {
        $teks = mb_strtolower(trim($teks));
        $teks = preg_replace('/\(.*?\)/', '', $teks);          // buang "(opsional)"
        $teks = preg_replace('/[^a-z0-9]+/', '_', $teks);

        return trim($teks, '_');
    }

    protected function tulisHeader(Worksheet $sheet): void
    {
        $lebar = ['A' => 18, 'B' => 30, 'C' => 28, 'D' => 24, 'E' => 20, 'F' => 22];
        $kolom = array_keys($lebar);

        foreach (array_values(self::KOLOM) as $i => $judul) {
            $sheet->setCellValue($kolom[$i] . '1', $judul);
            $sheet->getColumnDimension($kolom[$i])->setWidth($lebar[$kolom[$i]]);
        }

        $sheet->getStyle('A1:F1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'F0C040']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '0D1B2A']],
            'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(24);

        // Semua sel diperlakukan sebagai teks supaya NIM berawalan 0 tidak hilang.
        $sheet->getStyle('A2:A' . self::BARIS_TEMPLATE)
            ->getNumberFormat()->setFormatCode('@');
    }

    /**
     * Sheet tersembunyi berisi daftar pilihan, dirujuk oleh dropdown lewat named range.
     */
    protected function buatSheetReferensi(Spreadsheet $spreadsheet, array $prodi, array $tahunAjar): Worksheet
    {
        $sheet = $spreadsheet->createSheet();
        $sheet->setTitle('Referensi');

        $sheet->setCellValue('A1', 'Program Studi');
        $sheet->setCellValue('B1', 'Tahun Ajar');

        foreach ($prodi as $i => $nama) {
            $sheet->setCellValue('A' . ($i + 2), $nama);
        }

        foreach ($tahunAjar as $i => $label) {
            $sheet->setCellValue('B' . ($i + 2), $label);
        }

        $sheet->getColumnDimension('A')->setWidth(24);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->setSheetState(Worksheet::SHEETSTATE_HIDDEN);

        return $sheet;
    }

    protected function pasangDropdown(
        Worksheet $sheet,
        Spreadsheet $spreadsheet,
        Worksheet $referensi,
        array $prodi,
        array $tahunAjar
    ): void {
        // Named range dipakai agar dropdown tetap jalan walau sheet referensinya disembunyikan.
        $spreadsheet->addNamedRange(
            new NamedRange('DAFTAR_PRODI', $referensi, '$A$2:$A$' . (count($prodi) + 1))
        );
        $spreadsheet->addNamedRange(
            new NamedRange('DAFTAR_TAHUN_AJAR', $referensi, '$B$2:$B$' . (count($tahunAjar) + 1))
        );

        $daftar = [
            'D' => ['DAFTAR_PRODI', 'Program Studi', 'Pilih program studi dari daftar.'],
            'E' => ['DAFTAR_TAHUN_AJAR', 'Tahun Ajar', 'Pilih tahun ajar dari daftar.'],
        ];

        foreach ($daftar as $kolom => [$namedRange, $judul, $petunjuk]) {
            $validasi = new DataValidation();
            $validasi->setType(DataValidation::TYPE_LIST);
            $validasi->setErrorStyle(DataValidation::STYLE_STOP);
            $validasi->setAllowBlank(true);
            $validasi->setShowDropDown(true);
            $validasi->setShowInputMessage(true);
            $validasi->setShowErrorMessage(true);
            $validasi->setPromptTitle($judul);
            $validasi->setPrompt($petunjuk);
            $validasi->setErrorTitle('Pilihan tidak valid');
            $validasi->setError('Gunakan dropdown, nilai di luar daftar tidak diterima.');
            $validasi->setFormula1('=' . $namedRange);

            // Satu validasi untuk seluruh rentang, bukan satu per sel.
            $sheet->setDataValidation("{$kolom}2:{$kolom}" . self::BARIS_TEMPLATE, $validasi);
        }
    }

    protected function tulisPetunjuk(Spreadsheet $spreadsheet, array $prodi, array $tahunAjar): void
    {
        $sheet = $spreadsheet->createSheet();
        $sheet->setTitle('Petunjuk');
        $sheet->getColumnDimension('A')->setWidth(110);

        $isi = [
            'CARA MENGISI TEMPLATE IMPOR PESERTA',
            '',
            ' 1. Isi data mulai baris ke-2 pada sheet "Data Peserta". Jangan mengubah atau menghapus baris header.',
            ' 2. Kolom Program Studi dan Tahun Ajar HARUS dipilih lewat dropdown. Nilai di luar daftar akan ditolak.',
            ' 3. NIM wajib diisi, maksimal 20 karakter, dan tidak boleh sama dengan NIM yang sudah ada di sistem.',
            ' 4. Nama Lengkap wajib diisi.',
            ' 5. Email boleh dikosongkan. Kalau diisi, harus valid dan belum dipakai akun lain.',
            ' 6. Password boleh dikosongkan. Jika kosong, NIM dipakai sebagai password awal,',
            '    jadi mintalah peserta segera menggantinya. Kalau diisi, minimal 8 karakter.',
            ' 7. Semua peserta yang diimpor otomatis berrole "mahasiswa".',
            ' 8. Baris kosong diabaikan, jadi tidak perlu menghapus sisa baris yang tidak terpakai.',
            ' 9. Maksimal ' . self::MAKS_BARIS . ' baris sekali impor.',
            '10. Impor bersifat semua-atau-tidak: bila ada satu baris yang salah, tidak ada data yang tersimpan',
            '    dan seluruh kesalahan dilaporkan sekaligus beserta nomor barisnya.',
            '',
            'Daftar Program Studi yang tersedia: ' . implode(', ', $prodi),
            'Daftar Tahun Ajar yang tersedia: ' . implode(', ', $tahunAjar),
            '',
            'Template ini dibuat pada ' . now()->format('d M Y H:i') . '. Jika daftar tahun ajar berubah di sistem,',
            'unduh ulang template agar dropdown-nya ikut diperbarui.',
        ];

        foreach ($isi as $i => $teks) {
            $sheet->setCellValue('A' . ($i + 1), $teks);
        }

        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(13);
        $sheet->getStyle('A16:A17')->getFont()->setBold(true);
    }
}
