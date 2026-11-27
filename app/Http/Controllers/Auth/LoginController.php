<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

class LoginController extends Controller
{
    /**
     * Percobaan gagal yang ditoleransi sebelum login ditahan, dan berapa lama
     * tahanannya berlaku.
     *
     * Lima percobaan cukup longgar bagi orang yang lupa passwordnya, tetapi
     * membuat penebakan beruntun tidak lagi masuk akal: mencoba seribu
     * kemungkinan akan memakan waktu berhari-hari.
     */
    private const MAKS_PERCOBAAN = 5;
    private const JENDELA_DETIK = 900;

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'login' => 'required|string',
            'password' => 'required',
        ], [], [
            'login' => 'Email atau NIM',
        ]);

        $kunci = $this->kunciPembatas($request, $validated['login']);

        if (RateLimiter::tooManyAttempts($kunci, self::MAKS_PERCOBAAN)) {
            $detik = RateLimiter::availableIn($kunci);

            return back()->withErrors([
                'login' => 'Terlalu banyak percobaan masuk. Coba lagi dalam '
                    . ceil($detik / 60) . ' menit.',
            ])->onlyInput('login');
        }

        // Admin masuk pakai email, mahasiswa pakai NIM.
        $field = filter_var($validated['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'nim';

        $credentials = [
            $field => $validated['login'],
            'password' => $validated['password'],
        ];

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Hitungannya dinolkan supaya percobaan gagal sebelumnya tidak
            // menghalangi pemilik akun yang akhirnya ingat passwordnya.
            RateLimiter::clear($kunci);

            $request->session()->regenerate();

            // Dipakai fitur "Buat Akun" untuk menolak pembuatan password ulang
            // pada akun yang sudah pernah dipakai masuk. Disimpan tanpa
            // menyentuh updated_at supaya kolom itu tetap berarti "data diubah".
            Auth::user()->forceFill(['terakhir_login_pada' => now()])->saveQuietly();

            // Mahasiswa tidak punya akses panel admin, arahkan ke profilnya.
            return redirect()->intended(Auth::user()->isPengelola() ? '/admin' : '/profil');
        }

        RateLimiter::hit($kunci, self::JENDELA_DETIK);

        return back()->withErrors([
            'login' => 'Email/NIM atau password salah.',
        ])->onlyInput('login');
    }

    /**
     * Dikunci per kombinasi identitas dan alamat IP.
     *
     * Hanya per IP akan menjegal banyak mahasiswa yang berbagi satu jaringan
     * kampus atau kantor. Hanya per identitas membuat penyerang bisa menyapu
     * banyak akun dari satu tempat tanpa pernah tertahan.
     */
    private function kunciPembatas(Request $request, string $login): string
    {
        return 'login:' . sha1(mb_strtolower($login) . '|' . $request->ip());
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }
}
