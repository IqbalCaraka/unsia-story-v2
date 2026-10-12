<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect('/admin/login');
        }

        // Admin dan superadmin sama-sama boleh masuk panel. Mahasiswa memakai
        // login yang sama tapi diarahkan ke profilnya, bukan 403 buntu.
        if (!Auth::user()->isPengelola()) {
            return redirect()->route('profil.edit')
                ->with('error', 'Panel admin hanya untuk administrator.');
        }

        return $next($request);
    }
}
