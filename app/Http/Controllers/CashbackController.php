<?php

namespace App\Http\Controllers;

use App\Models\PengajuanCashback;
use App\Models\TahunAjar;
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

        // Saat terkunci, daftar periode tidak perlu diambil sama sekali —
        // formulirnya memang tidak ditampilkan.
        $periodeTersedia = $klaimPengunci
            ? collect()
            : TahunAjar::where('nominal_cashback', '>', 0)
                ->orderByDesc('tahun_ajar')
                ->orderBy('ganjil_genap')
                ->get();

        return view('cashback.index', [
            'pengajuanList' => $pengajuan,
            'periodeTersedia' => $periodeTersedia,
            'klaimPengunci' => $klaimPengunci,
            'daftarBank' => PengajuanCashback::daftarBank(),
            'daftarEwallet' => PengajuanCashback::daftarEwallet(),
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        abort_unless($user->isMahasiswa(), 403);

        $metode = $request->input('metode');

        $validated = $request->validate([
            // Closure, bukan ->where('nominal_cashback', '>', 0): Rule::exists()->where()
            // hanya menerima (kolom, nilai), operatornya akan diperlakukan sebagai nilai.
            'tahun_ajar_id' => [
                'required',
                Rule::exists('tahun_ajar', 'id')->where(fn ($q) => $q->where('nominal_cashback', '>', 0)),
            ],
            'metode' => ['required', Rule::in(['bank', 'ewallet'])],
            'penyedia' => ['required', Rule::in(PengajuanCashback::daftarPenyedia($metode ?? 'bank'))],
            'nomor' => ['required', 'string', 'max:50', 'regex:/^[0-9][0-9 \-]*$/'],
            'atas_nama' => ['required', 'string', 'max:150'],
            'catatan' => ['nullable', 'string', 'max:500'],
        ], [
            'tahun_ajar_id.exists' => 'Periode tersebut tidak membuka cashback.',
            'penyedia.in' => 'Pilih penyedia dari daftar yang tersedia.',
            'nomor.regex' => 'Nomor hanya boleh berisi angka, spasi, dan tanda hubung.',
        ], [
            'tahun_ajar_id' => 'periode',
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

        $periode = TahunAjar::findOrFail($validated['tahun_ajar_id']);

        PengajuanCashback::create($validated + [
            'user_id' => $user->id,
            // Nominal dibekukan saat pengajuan dibuat.
            'jumlah' => $periode->nominal_cashback,
        ]);

        return redirect()->route('cashback.index')
            ->with('success', 'Pengajuan cashback terkirim dan menunggu verifikasi admin.');
    }

    public function batal(PengajuanCashback $cashback)
    {
        abort_unless($cashback->user_id === Auth::id(), 403);

        if (! $cashback->isMenunggu()) {
            return back()->with('error', 'Pengajuan yang sudah diproses admin tidak bisa dibatalkan.');
        }

        $cashback->delete();

        return redirect()->route('cashback.index')->with('success', 'Pengajuan dibatalkan.');
    }

    /**
     * Mahasiswa mengunduh bukti transfer miliknya sendiri.
     */
    public function bukti(PengajuanCashback $cashback): StreamedResponse
    {
        abort_unless($cashback->user_id === Auth::id(), 403);
        abort_unless($cashback->bukti_path && Storage::disk('local')->exists($cashback->bukti_path), 404);

        return Storage::disk('local')->download($cashback->bukti_path, $cashback->bukti_nama);
    }
}
