<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Pastikan user yang login adalah admin (is_admin = true).
     * Dipasang setelah middleware 'auth', jadi di sini user
     * dipastikan sudah login -- tinggal cek rolenya.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->is_admin) {
            abort(403, 'Halaman ini khusus untuk admin.');
        }

        return $next($request);
    }
}