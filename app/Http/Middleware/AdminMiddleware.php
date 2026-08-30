<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware untuk membatasi akses hanya untuk admin.
 *
 * Menggunakan kontrol alur if/else untuk mengecek role user.
 * Jika user bukan admin, redirect ke dashboard dengan pesan error.
 */
class AdminMiddleware
{
    /**
     * Menangani request yang masuk.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Kontrol alur: cek apakah user yang login adalah admin
        if (!$request->user() || !$request->user()->isAdmin()) {
            return redirect()->route('dashboard')
                ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        return $next($request);
    }
}
