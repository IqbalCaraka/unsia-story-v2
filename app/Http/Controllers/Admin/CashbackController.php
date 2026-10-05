<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengajuanCashback;
use App\Models\TahunAjar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CashbackController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status', 'menunggu');
        $periode = $request->input('tahun_ajar_id');

        // Dipakai ulang untuk daftar, hitungan tab, dan total rupiah, supaya
        // semuanya bicara tentang periode yang sama saat difilter.
        $dasar = fn () => PengajuanCashback::query()
            ->when($periode, fn ($q) => $q->where('tahun_ajar_id', $periode))
            ->when($request->filled('q'), function ($q) use ($request) {
                $cari = '%' . $request->q . '%';
                $q->whereHas('user', fn ($u) => $u->where('nama', 'like', $cari)
                    ->orWhere('name', 'like', $cari)
                    ->orWhere('nim', 'like', $cari));
            });

        $pengajuanList = $dasar()
            ->with(['user.prodi', 'tahunAjar', 'verifikator', 'pembayar'])
            ->when(in_array($status, ['menunggu', 'diverifikasi', 'dibayar', 'ditolak'], true),
                fn ($q) => $q->where('status', $status))
            ->latest('id')
            ->paginate(20)
            ->withQueryString();

        return view('admin.cashback.index', [
            'pengajuanList' => $pengajuanList,
            'status' => $status,
            'periode' => $periode,
            // Hanya periode yang benar-benar punya pengajuan, biar dropdownnya tidak penuh pilihan kosong.
            'periodeList' => TahunAjar::whereHas('pengajuanCashback')
                ->orderByDesc('tahun_ajar')->orderBy('ganjil_genap')->get(),
            'jumlah' => [
                'menunggu' => $dasar()->where('status', 'menunggu')->count(),
                'diverifikasi' => $dasar()->where('status', 'diverifikasi')->count(),
                'dibayar' => $dasar()->where('status', 'dibayar')->count(),
                'ditolak' => $dasar()->where('status', 'ditolak')->count(),
            ],
            'totalDibayar' => (float) $dasar()->where('status', 'dibayar')->sum('jumlah'),
            'totalTerutang' => (float) $dasar()->whereIn('status', ['menunggu', 'diverifikasi'])->sum('jumlah'),
        ]);
    }

    /**
     * Langkah 1: admin memastikan data rekening benar.
     */
    public function verifikasi(Request $request, PengajuanCashback $cashback)
    {
        if (! $cashback->isMenunggu()) {
            return back()->with('error', 'Pengajuan ini sudah diproses sebelumnya.');
        }

        $request->validate(['catatan_admin' => ['nullable', 'string', 'max:500']]);

        $cashback->update([
            'status' => 'diverifikasi',
            'catatan_admin' => $request->input('catatan_admin'),
            'diverifikasi_oleh' => auth()->id(),
            'diverifikasi_pada' => now(),
        ]);

        return back()->with('success',
            "Pengajuan {$cashback->user->nama} diverifikasi. Silakan transfer lalu unggah buktinya.");
    }

    /**
     * Langkah 2: admin sudah transfer, unggah bukti.
     */
    public function bayar(Request $request, PengajuanCashback $cashback)
    {
        if (! $cashback->isDiverifikasi()) {
            return back()->with('error', 'Hanya pengajuan yang sudah diverifikasi yang bisa ditandai dibayar.');
        }

        $validated = $request->validate([
            'bukti' => ['required', 'file', 'mimes:jpeg,jpg,png,webp,pdf', 'max:4096'],
            'catatan_admin' => ['nullable', 'string', 'max:500'],
        ], [
            'bukti.required' => 'Bukti pembayaran wajib dilampirkan.',
        ], [
            'bukti' => 'bukti pembayaran',
        ]);

        $berkas = $validated['bukti'];
        $namaSimpan = 'cashback-' . $cashback->id . '-' . time() . '.' . $berkas->getClientOriginalExtension();

        // Disk private: bukti transfer tidak boleh bisa ditebak lewat URL publik.
        $path = $berkas->storeAs('bukti-cashback', $namaSimpan, 'local');

        $cashback->update([
            'status' => 'dibayar',
            'bukti_path' => $path,
            'bukti_nama' => $berkas->getClientOriginalName(),
            'catatan_admin' => $validated['catatan_admin'] ?? $cashback->catatan_admin,
            'dibayar_oleh' => auth()->id(),
            'dibayar_pada' => now(),
        ]);

        return back()->with('success',
            "Cashback {$cashback->jumlah_rupiah} untuk {$cashback->user->nama} ditandai sudah dibayar.");
    }

    public function tolak(Request $request, PengajuanCashback $cashback)
    {
        if ($cashback->isDibayar() || $cashback->status === 'ditolak') {
            return back()->with('error', 'Pengajuan ini sudah selesai diproses.');
        }

        $validated = $request->validate([
            'catatan_admin' => ['required', 'string', 'max:500'],
        ], [
            'catatan_admin.required' => 'Tuliskan alasan penolakan agar mahasiswa tahu penyebabnya.',
        ], [
            'catatan_admin' => 'alasan penolakan',
        ]);

        $cashback->update([
            'status' => 'ditolak',
            'catatan_admin' => $validated['catatan_admin'],
            'diverifikasi_oleh' => auth()->id(),
            'diverifikasi_pada' => now(),
        ]);

        return back()->with('success', 'Pengajuan ditolak. Mahasiswa bisa mengajukan ulang untuk periode itu.');
    }

    public function bukti(PengajuanCashback $cashback): StreamedResponse
    {
        abort_unless($cashback->bukti_path && Storage::disk('local')->exists($cashback->bukti_path), 404);

        return Storage::disk('local')->download($cashback->bukti_path, $cashback->bukti_nama);
    }
}
