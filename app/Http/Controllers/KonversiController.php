<?php

namespace App\Http\Controllers;

use App\Models\RplLead;
use App\Services\KonversiMatcher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KonversiController extends Controller
{
    private const JENIS_LABEL = [
        'pindahan' => 'Transfer Kuliah Belum Selesai (S1)',
        'alih_jenjang' => 'Alih Jenjang Diploma (D3)',
    ];

    public function index()
    {
        return view('pages.konversi', ['step' => 'input']);
    }

    /**
     * Step 1: pilih jenis konversi + mata kuliah.
     * Step 2: isi data diri, lalu tampilkan hasil analisis.
     */
    public function process(Request $request, KonversiMatcher $matcher)
    {
        $step = $request->input('step');

        if ($step === 'mk_selected') {
            $validated = $request->validate([
                'jenis_rpl' => 'required|in:pindahan,alih_jenjang',
                'mata_kuliah' => 'required|string',
            ]);

            if ($this->parseMataKuliah($validated['mata_kuliah'])['all'] === []) {
                return redirect()->route('konversi')
                    ->with('konversi_error', 'Pilih minimal satu mata kuliah terlebih dahulu.');
            }

            return view('pages.konversi', [
                'step' => 'lead',
                'jenis_rpl' => $validated['jenis_rpl'],
                'mata_kuliah' => $validated['mata_kuliah'],
            ]);
        }

        if ($step !== 'lead_submitted') {
            return redirect()->route('konversi');
        }

        $jenisRpl = $request->input('jenis_rpl');
        $mataKuliahRaw = (string) $request->input('mata_kuliah', '');
        $parsed = $this->parseMataKuliah($mataKuliahRaw);

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:200',
            'email' => 'required|email|max:200',
            'whatsapp' => 'required|regex:/^[0-9]{10,15}$/',
            'jenis_rpl' => 'required|in:pindahan,alih_jenjang',
        ], [
            'email.email' => 'Format email tidak valid.',
            'whatsapp.regex' => 'Nomor WhatsApp minimal 10 digit angka.',
        ]);

        if ($parsed['all'] === []) {
            $validator->after(fn ($v) => $v->errors()->add('mata_kuliah', 'Mohon isi semua data dengan lengkap.'));
        }

        if ($validator->fails()) {
            return view('pages.konversi', [
                'step' => 'lead',
                'jenis_rpl' => $jenisRpl,
                'mata_kuliah' => $mataKuliahRaw,
                'errorMessage' => $validator->errors()->first(),
            ])->withErrors($validator);
        }

        $nama = trim($request->input('nama'));
        $email = trim($request->input('email'));
        $whatsapp = preg_replace('/[^0-9+]/', '', trim($request->input('whatsapp')));
        $jenisLabel = self::JENIS_LABEL[$jenisRpl];

        $results = $matcher->analyze($parsed['all']);
        $freetextAnalysis = $matcher->analyzeFreetext($parsed['freetext']);

        RplLead::create([
            'nama' => $nama,
            'email' => $email,
            'whatsapp' => $whatsapp,
            'sumber' => 'RPL Konversi',
            'prodi_cocok' => $results[0]['prodi'] ?? '',
            'jenis_rpl' => $jenisLabel,
            'input_mk' => json_encode([
                'selected' => $parsed['selected'],
                'freetext' => $freetextAnalysis,
            ], JSON_UNESCAPED_UNICODE),
        ]);

        $request->session()->put('rpl', [
            'results' => $results,
            'nama' => $nama,
            'jenis' => $jenisLabel,
            'input_mk' => $parsed['all'],
            'freetext' => $freetextAnalysis,
        ]);

        return view('pages.konversi', [
            'step' => 'result',
            'results' => $results,
            'freetextAnalysis' => $freetextAnalysis,
            'nama' => $nama,
            'jenisLabel' => $jenisLabel,
            'inputMk' => $parsed['all'],
            'selectedMk' => $parsed['selected'],
            'freetextMk' => $parsed['freetext'],
        ]);
    }

    /**
     * Laporan siap cetak dari hasil analisis terakhir.
     */
    public function laporan(Request $request)
    {
        $rpl = $request->session()->get('rpl');

        if (! $rpl) {
            return redirect()->route('konversi');
        }

        return view('pages.konversi-laporan', $rpl);
    }

    /**
     * Pecah input JSON [{name,type}] menjadi daftar MK terpilih & manual.
     *
     * @return array{all: array<int,string>, selected: array<int,string>, freetext: array<int,string>}
     */
    private function parseMataKuliah(string $raw): array
    {
        $data = json_decode(html_entity_decode($raw, ENT_QUOTES, 'UTF-8'), true);

        $all = [];
        $selected = [];
        $freetext = [];

        if (is_array($data)) {
            foreach (array_slice($data, 0, 100) as $item) {
                if (is_array($item) && isset($item['name'])) {
                    $name = trim((string) $item['name']);
                    $type = $item['type'] ?? 'selected';
                } else {
                    $name = trim((string) $item);
                    $type = 'selected';
                }

                if ($name === '') {
                    continue;
                }

                $all[] = $name;

                if ($type === 'freetext') {
                    $freetext[] = $name;
                } else {
                    $selected[] = $name;
                }
            }
        }

        return ['all' => $all, 'selected' => $selected, 'freetext' => $freetext];
    }
}
