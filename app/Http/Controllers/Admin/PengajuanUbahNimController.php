<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengajuanUbahNim;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengajuanUbahNimController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status', 'menunggu');

        $pengajuanList = PengajuanUbahNim::with(['user.prodi', 'pemroses'])
            ->when(in_array($status, ['menunggu', 'disetujui', 'ditolak'], true),
                fn ($q) => $q->where('status', $status))
            ->latest('id')
            ->paginate(20)
            ->withQueryString();

        return view('admin.pengajuan-nim.index', [
            'pengajuanList' => $pengajuanList,
            'status' => $status,
            'jumlahMenunggu' => PengajuanUbahNim::menunggu()->count(),
        ]);
    }

    public function setujui(Request $request, PengajuanUbahNim $pengajuan)
    {
        if (! $pengajuan->isMenunggu()) {
            return back()->with('error', 'Pengajuan ini sudah diproses sebelumnya.');
        }

        $request->validate(['catatan_admin' => ['nullable', 'string', 'max:500']]);

        // NIM bisa saja keburu dipakai orang lain sejak pengajuan dibuat.
        $bentrok = User::where('nim', $pengajuan->nim_baru)
            ->where('id', '!=', $pengajuan->user_id)
            ->exists();

        if ($bentrok) {
            return back()->with('error',
                "NIM {$pengajuan->nim_baru} sudah dipakai akun lain. Tolak pengajuan ini atau minta NIM lain.");
        }

        DB::transaction(function () use ($pengajuan, $request) {
            $pengajuan->user->update(['nim' => $pengajuan->nim_baru]);

            $pengajuan->update([
                'status' => 'disetujui',
                'catatan_admin' => $request->input('catatan_admin'),
                'diproses_oleh' => auth()->id(),
                'diproses_pada' => now(),
            ]);
        });

        return back()->with('success',
            "NIM {$pengajuan->user->nama} diubah menjadi {$pengajuan->nim_baru}.");
    }

    public function tolak(Request $request, PengajuanUbahNim $pengajuan)
    {
        if (! $pengajuan->isMenunggu()) {
            return back()->with('error', 'Pengajuan ini sudah diproses sebelumnya.');
        }

        $validated = $request->validate([
            'catatan_admin' => ['required', 'string', 'max:500'],
        ], [
            'catatan_admin.required' => 'Tuliskan alasan penolakan agar mahasiswa tahu penyebabnya.',
        ], [
            'catatan_admin' => 'alasan penolakan',
        ]);

        $pengajuan->update([
            'status' => 'ditolak',
            'catatan_admin' => $validated['catatan_admin'],
            'diproses_oleh' => auth()->id(),
            'diproses_pada' => now(),
        ]);

        return back()->with('success', 'Pengajuan ditolak.');
    }
}
