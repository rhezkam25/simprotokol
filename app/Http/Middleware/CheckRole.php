<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    // Tambahkan ...$roles agar bisa menerima banyak role sekaligus
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Jika user belum login, atau role-nya tidak ada di daftar yang diizinkan
        if (!auth()->check() || !in_array(auth()->user()->role, $roles)) {
            // Tolak akses (Bisa diarahkan ke halaman 403 atau dashboard)
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}