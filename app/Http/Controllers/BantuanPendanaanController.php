<?php

namespace App\Http\Controllers;

use App\Models\PengajuanBantuan;
use Illuminate\Http\Request;

class BantuanPendanaanController extends Controller
{
    /**
     * Halaman informasi program bantuan pendanaan.
     */
    public function index()
    {
        return view('pages.bantuan-pendanaan');
    }

    /**
     * Formulir pengajuan bantuan pendanaan.
     */
    public function ajukan()
    {
        return view('pages.bantuan-ajukan', [
            'daftarProdi' => PengajuanBantuan::daftarProdi(),
        ]);
    }

    /**
     * Simpan pengajuan beserta berkas transkrip & lembar motivasi.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:200',
            'nim' => 'required|string|max:50',
            'email' => 'required|email|max:200',
            'whatsapp' => 'required|regex:/^[0-9]{10,15}$/',
            'prodi' => 'required|in:' . implode(',', PengajuanBantuan::daftarProdi()),
            'ip_semester_1' => 'required|numeric|min:0|max:4',
            'transkrip' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'motivasi' => 'required|file|mimes:pdf,doc,docx|max:5120',
            'catatan' => 'nullable|string|max:1000',
            'persetujuan' => 'accepted',
        ], [
            'whatsapp.regex' => 'Nomor WhatsApp harus 10-15 digit angka.',
            'ip_semester_1.max' => 'IP semester 1 maksimal 4.00.',
            'transkrip.mimes' => 'Transkrip nilai harus berformat PDF, JPG, atau PNG.',
            'motivasi.mimes' => 'Lembar motivasi harus berformat PDF, DOC, atau DOCX.',
            'persetujuan.accepted' => 'Kamu harus menyetujui pernyataan penggunaan kode referral dan kebenaran data.',
        ]);

        // Berkas disimpan di disk privat, hanya bisa diunduh lewat panel admin.
        $folder = 'bantuan-pendanaan/' . now()->format('Y');
        $transkrip = $request->file('transkrip');
        $motivasi = $request->file('motivasi');

        $pengajuan = PengajuanBantuan::create([
            'nama_lengkap' => $validated['nama_lengkap'],
            'nim' => $validated['nim'],
            'email' => $validated['email'],
            'whatsapp' => preg_replace('/[^0-9]/', '', $validated['whatsapp']),
            'prodi' => $validated['prodi'],
            'ip_semester_1' => $validated['ip_semester_1'],
            'transkrip_path' => $transkrip->store($folder, 'local'),
            'transkrip_nama' => $transkrip->getClientOriginalName(),
            'motivasi_path' => $motivasi->store($folder, 'local'),
            'motivasi_nama' => $motivasi->getClientOriginalName(),
            'catatan' => $validated['catatan'] ?? null,
            'status' => 'pending',
        ]);

        return redirect()->route('bantuan.ajukan')
            ->with('pengajuan_sukses', [
                'nomor' => str_pad((string) $pengajuan->id, 5, '0', STR_PAD_LEFT),
                'nama' => $pengajuan->nama_lengkap,
                'email' => $pengajuan->email,
            ]);
    }
}
