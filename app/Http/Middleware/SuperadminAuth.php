<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Hanya superadmin. Dipakai untuk manajemen pengguna, karena admin biasa
 * tidak boleh membuat, mengubah, atau menghapus akun siapa pun.
 */
class SuperadminAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            return redirect('/admin/login');
        }

        if (! Auth::user()->isSuperadmin()) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Manajemen pengguna hanya untuk Super Admin.');
        }

        return $next($request);
    }
}
