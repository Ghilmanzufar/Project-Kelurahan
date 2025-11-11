<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- Pastikan ini di-import
use Symfony\Component\HttpFoundation\Response;

class CheckRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek apakah pengguna sudah login.
        // (Meskipun rute kita nanti akan dilindungi 'auth', ini adalah pengaman ganda)
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2. Ambil role dari pengguna yang sedang login.
        $userRole = Auth::user()->role;

        // 3. Tentukan role apa saja yang BOLEH mengakses halaman admin.
        // (Sesuai dengan rencana kita: super_admin, petugas_layanan, pimpinan)
        $allowedRoles = [
            'super_admin',
            'petugas_layanan',
            'pimpinan',
        ];

        // 4. Cek apakah role pengguna ada di dalam daftar yang diizinkan.
        if (in_array($userRole, $allowedRoles)) {
            // 5. Jika diizinkan, lanjutkan ke halaman yang dituju (misal: /admin/dashboard)
            return $next($request);
        }

        // 6. Jika TIDAK diizinkan (misal: role 'warga' atau lainnya),
        //    hentikan request dan tampilkan halaman 403 (Akses Ditolak).
        abort(403, 'AKSES DITOLAK. ANDA TIDAK MEMILIKI HAK AKSES YANG SESUAI.');
    }
}