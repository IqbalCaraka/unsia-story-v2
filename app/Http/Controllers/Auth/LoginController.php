<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
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

        // Admin masuk pakai email, mahasiswa pakai NIM.
        $field = filter_var($validated['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'nim';

        $credentials = [
            $field => $validated['login'],
            'password' => $validated['password'],
        ];

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Mahasiswa tidak punya akses panel admin, arahkan ke profilnya.
            return redirect()->intended(Auth::user()->isAdmin() ? '/admin' : '/profil');
        }

        return back()->withErrors([
            'login' => 'Email/NIM atau password salah.',
        ])->onlyInput('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }
}
