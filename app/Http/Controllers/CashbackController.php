<?php

namespace App\Http\Controllers;

use App\Models\LogCashback;
use App\Models\PengajuanCashback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CashbackController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        abort_unless($user->isMahasiswa(), 403, 'Pengajuan cashback hanya untuk akun mahasiswa.');

        $pengajuan = $user->pengajuanCashback()
            ->with(['tahunAjar', 'verifikator', 'pembayar'])
            ->latest('id')
            ->get();

        // Cashback hanya bisa diterima sekali. Klaim yang sudah disetujui, atau
        // yang masih diproses, menutup pengajuan baru untuk periode mana pun.
        $klaimPengunci = $pengajuan
            ->whereIn('status', PengajuanCashback::STATUS_AKTIF)
            ->first();

        // Periode tidak dipilih mahasiswa, melainkan diambil dari periode
        // tempat ia terdaftar. Cashback melekat pada pemakaian kode referal
        // saat mendaftar, jadi periodenya sudah tertentu — membiarkan mahasiswa
        // memilih sendiri hanya membuka peluang salah pilih.
        $periode = $user->tahunAjar;

        return view('cashback.index', [
            'pengajuanList' => $pengajuan,
            'periode' => $periode,
            'periodeDibuka' => $periode?->cashbackDibuka() ?? false,
            'klaimPengunci' => $klaimPengunci,
            'daftarEwallet' => PengajuanCashback::daftarEwallet(),
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        abort_unless($user->isMahasiswa(), 403);

        // Periode diambil dari data mahasiswa, bukan dari kiriman form.
        // Dengan begitu tidak ada cara mengajukan atas nama periode lain,
        // sekalipun isian formnya dipalsukan.
        $periode = $user->tahunAjar;

        if (! $periode) {
            return back()->withInput()->with('error',
                'Data tahun ajar Anda belum terisi, sehingga cashback belum bisa diajukan. Hubungi admin.');
        }

        if (! $periode->cashbackDibuka()) {
            return back()->withInput()->with('error',
                "Cashback untuk periode {$periode->label} belum dibuka. Hubungi admin bila Anda merasa seharusnya sudah bisa mengajukan.");
        }

        // Pemisah yang biasa ikut saat nomor disalin dirapikan dulu, jadi
        // "0812-3456-7890" dan "+62 812 3456 7890" tetap diterima dan sama-sama
        // tersimpan sebagai angka saja. Huruf dan tanda lain tidak dibuang —
        // isian seperti itu memang keliru dan harus ditolak, bukan dibersihkan
        // diam-diam sampai menjadi nomor yang bukan dimaksud penggunanya.
        $request->merge([
            'nomor' => preg_replace('/[\s\-.()+]/', '', (string) $request->input('nomor')),
        ]);

        $validated = $request->validate([
            'penyedia' => ['required', Rule::in(PengajuanCashback::daftarEwallet())],
            // Hanya angka. Batas 8-20 digit menjaring salah ketik yang kentara
            // tanpa memaksakan pola nomor tertentu, karena tiap penyedia punya
            // aturannya sendiri dan nomor yang sah tidak boleh ikut tertolak.
            'nomor' => ['required', 'string', 'regex:/^[0-9]{8,20}$/'],
            // Rekening harus atas nama mahasiswa sendiri. Dicegat di sini,
            // bukan dibiarkan sampai admin menolaknya, supaya mahasiswa tahu
            // penyebabnya saat itu juga dan tidak menunggu sia-sia.
            'atas_nama' => [
                'required', 'string', 'max:150',
                function (string $atribut, mixed $nilai, callable $gagal) use ($user) {
                    if (! PengajuanCashback::namaCocok($nilai, $user->nama ?? $user->name)) {
                        $gagal('Nama pemilik rekening harus sama dengan nama Anda: '
                            . ($user->nama ?? $user->name) . '.');
                    }
                },
            ],
            'catatan' => ['nullable', 'string', 'max:500'],
        ], [
            'penyedia.in' => 'Pilih e-wallet dari daftar yang tersedia.',
            'nomor.regex' => 'Nomor e-wallet hanya boleh berisi angka, 8 sampai 20 digit.',
        ], [
            'atas_nama' => 'nama pemilik rekening',
        ]);

        // Dikunci menyeluruh, bukan per periode: cashback melekat pada
        // pemakaian kode referal saat mendaftar, yang terjadi satu kali.
        if (PengajuanCashback::sudahPernahDisetujui($user->id)) {
            return back()->withInput()
                ->with('error', 'Cashback Anda sudah disetujui sebelumnya. Cashback hanya dapat diterima satu kali.');
        }

        if (PengajuanCashback::adaKlaimBerjalan($user->id)) {
            return back()->withInput()
                ->with('error', 'Masih ada pengajuan cashback Anda yang sedang diproses. Tunggu keputusan admin dulu.');
        }

        $pengajuan = PengajuanCashback::create($validated + [
            'user_id' => $user->id,
            'tahun_ajar_id' => $periode->id,
            // Hanya e-wallet yang dilayani, jadi tidak ditanyakan ke mahasiswa.
            'metode' => PengajuanCashback::METODE,
            // Nominal dibekukan saat pengajuan dibuat.
            'jumlah' => $periode->nominal_cashback,
        ]);

        LogCashback::catat(
            $pengajuan, 'diajukan', $user->id, null, 'menunggu',
            $pengajuan->tujuan,
        );

        return redirect()->route('cashback.index')->with('success',
            'Pengajuan cashback terkirim dan menunggu verifikasi admin. '
            . 'Perlu diingat, biaya transfer ditanggung penerima sehingga jumlah yang masuk '
            . 'sedikit lebih kecil dari ' . $periode->nominal_rupiah . '.');
    }

    public function batal(PengajuanCashback $cashback)
    {
        abort_unless($cashback->user_id === Auth::id(), 403);

        if (! $cashback->isMenunggu()) {
            return back()->with('error', 'Pengajuan yang sudah diproses admin tidak bisa dibatalkan.');
        }

        // Ditandai, bukan dihapus: menghapus barisnya akan menghapus lognya
        // juga lewat cascade, sehingga justru peristiwa pembatalan yang ingin
        // dicatat ikut hilang. Status "dibatalkan" tidak mengunci pengajuan
        // berikutnya.
        $cashback->update(['status' => 'dibatalkan']);

        LogCashback::catat($cashback, 'dibatalkan', Auth::id(), 'menunggu', 'dibatalkan');

        return redirect()->route('cashback.index')->with('success', 'Pengajuan dibatalkan.');
    }

    /**
     * Bukti transfer milik mahasiswa itu sendiri.
     *
     * Ditampilkan langsung di peramban, bukan dipaksa terunduh: mahasiswa
     * umumnya hanya ingin melihat sekilas bahwa transfernya benar, dan
     * memaksanya menyimpan berkas lebih dulu hanya menambah langkah serta
     * memenuhi folder unduhan.
     *
     * Dengan ?unduh=1 berkasnya tetap bisa disimpan.
     */
    public function bukti(Request $request, PengajuanCashback $cashback): StreamedResponse
    {
        abort_unless($cashback->user_id === Auth::id(), 403);
        abort_unless($cashback->bukti_path && Storage::disk('local')->exists($cashback->bukti_path), 404);

        $disk = Storage::disk('local');

        return $request->boolean('unduh')
            ? $disk->download($cashback->bukti_path, $cashback->bukti_nama)
            : $disk->response($cashback->bukti_path, $cashback->bukti_nama);
    }
}
