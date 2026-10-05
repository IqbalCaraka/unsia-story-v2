<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengajuanBantuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PengajuanBantuanController extends Controller
{
    public function index(Request $request)
    {
        $urutan = $request->query('urut', 'ip');

        $pengajuan = PengajuanBantuan::query()
            ->when($request->query('status'), fn ($q, $status) => $q->where('status', $status))
            ->when($urutan === 'ip',
                fn ($q) => $q->orderByDesc('ip_semester_1')->orderBy('created_at'),
                fn ($q) => $q->latest(),
            )
            ->paginate(20)
            ->withQueryString();

        return view('admin.bantuan.index', [
            'pengajuan' => $pengajuan,
            'urutan' => $urutan,
            'statusAktif' => $request->query('status'),
            'jumlah' => [
                'total' => PengajuanBantuan::count(),
                'pending' => PengajuanBantuan::where('status', 'pending')->count(),
                'verified' => PengajuanBantuan::where('status', 'verified')->count(),
                'rejected' => PengajuanBantuan::where('status', 'rejected')->count(),
            ],
        ]);
    }

    /**
     * Unduh berkas pemohon (transkrip / lembar motivasi).
     */
    public function berkas(string $id, string $jenis): StreamedResponse
    {
        abort_unless(in_array($jenis, ['transkrip', 'motivasi'], true), 404);

        $pengajuan = PengajuanBantuan::findOrFail($id);
        $path = $pengajuan->{$jenis . '_path'};

        abort_unless(Storage::disk('local')->exists($path), 404);

        return Storage::disk('local')->download($path, $pengajuan->{$jenis . '_nama'});
    }

    public function updateStatus(Request $request, string $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,verified,rejected',
        ]);

        PengajuanBantuan::findOrFail($id)->update(['status' => $validated['status']]);

        return redirect()->back()->with('success', 'Status pengajuan berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $pengajuan = PengajuanBantuan::findOrFail($id);

        Storage::disk('local')->delete([$pengajuan->transkrip_path, $pengajuan->motivasi_path]);
        $pengajuan->delete();

        return redirect()->route('admin.bantuan.index')
            ->with('success', 'Pengajuan berhasil dihapus.');
    }
}
