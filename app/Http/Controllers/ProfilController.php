<?php

namespace App\Http\Controllers;

use App\Models\PengajuanUbahNim;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class ProfilController extends Controller
{
    public function edit()
    {
        $user = Auth::user()->load(['prodi', 'tahunAjar']);

        return view('profil.edit', [
            'user' => $user,
            'pengajuanMenunggu' => $user->pengajuanNimMenunggu(),
            'riwayatPengajuan' => $user->pengajuanUbahNim()
                ->with('pemroses')->latest('id')->limit(5)->get(),
        ]);
    }

    /**
     * Ubah nama, email, foto, dan password milik sendiri.
     * NIM sengaja tidak ada di sini: hanya admin yang boleh mengubahnya.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],

            // Admin login pakai email, jadi tidak boleh dikosongkan.
            'email' => [
                $user->isAdmin() ? 'required' : 'nullable',
                'email', 'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            'foto_profil' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],

            'password_lama' => ['nullable', 'required_with:password', 'current_password'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ], [
            'password_lama.required_with' => 'Password saat ini wajib diisi untuk mengganti password.',
            'password_lama.current_password' => 'Password saat ini salah.',
            'email.required' => 'Akun admin wajib punya email, karena login admin memakai email.',
        ], [
            'foto_profil' => 'foto profil',
            'password_lama' => 'password saat ini',
        ]);

        $user->nama = $validated['nama'];
        $user->name = $validated['nama'];
        $user->email = $validated['email'] ?? null;

        if ($request->hasFile('foto_profil')) {
            $this->hapusBerkasFoto($user);
            $user->foto_profil = $this->simpanFoto($request->file('foto_profil'));
        }

        if (filled($validated['password'] ?? null)) {
            $user->password = $validated['password'];
        }

        $user->save();

        return redirect()->route('profil.edit')->with('success', 'Profil berhasil diperbarui.');
    }

    public function hapusFoto()
    {
        $user = Auth::user();

        $this->hapusBerkasFoto($user);
        $user->update(['foto_profil' => null]);

        return redirect()->route('profil.edit')->with('success', 'Foto profil dihapus.');
    }

    /**
     * Mahasiswa tidak bisa mengubah NIM sendiri, hanya mengajukan ke admin.
     */
    public function ajukanUbahNim(Request $request)
    {
        $user = Auth::user();

        if (! $user->isMahasiswa()) {
            return back()->with('error', 'Pengajuan ubah NIM hanya untuk akun mahasiswa.');
        }

        if ($user->pengajuanNimMenunggu()) {
            return back()->with('error', 'Masih ada pengajuan yang menunggu keputusan admin.');
        }

        $validated = $request->validate([
            'nim_baru' => [
                'required', 'string', 'max:20',
                Rule::unique('users', 'nim'),
                Rule::unique('pengajuan_ubah_nim', 'nim_baru')->where('status', 'menunggu'),
                Rule::notIn([$user->nim]),
            ],
            'alasan' => ['required', 'string', 'min:10', 'max:500'],
        ], [
            'nim_baru.unique' => 'NIM tersebut sudah dipakai atau sedang diajukan orang lain.',
            'nim_baru.not_in' => 'NIM baru sama dengan NIM Anda sekarang.',
            'alasan.min' => 'Jelaskan alasannya minimal 10 karakter.',
        ], [
            'nim_baru' => 'NIM baru',
        ]);

        PengajuanUbahNim::create([
            'user_id' => $user->id,
            'nim_lama' => $user->nim,
            'nim_baru' => $validated['nim_baru'],
            'alasan' => $validated['alasan'],
        ]);

        return redirect()->route('profil.edit')
            ->with('success', 'Pengajuan ubah NIM terkirim dan menunggu persetujuan admin.');
    }

    public function batalkanPengajuan(PengajuanUbahNim $pengajuan)
    {
        if ($pengajuan->user_id !== Auth::id() || ! $pengajuan->isMenunggu()) {
            abort(403);
        }

        $pengajuan->delete();

        return redirect()->route('profil.edit')->with('success', 'Pengajuan dibatalkan.');
    }

    protected function simpanFoto($file): string
    {
        $namaBerkas = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images/avatar'), $namaBerkas);

        return 'images/avatar/' . $namaBerkas;
    }

    protected function hapusBerkasFoto(User $user): void
    {
        if ($user->foto_profil && File::exists(public_path($user->foto_profil))) {
            File::delete(public_path($user->foto_profil));
        }
    }
}
