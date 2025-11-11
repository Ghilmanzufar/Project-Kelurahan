<?php

namespace App\Http\Controllers\Admin; // Pastikan namespace-nya Admin

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking; 

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman admin dashboard.
     */
    public function index()
    {
        // Ambil 5 booking terbaru yang statusnya 'JANJI TEMU DIBUAT' (perlu konfirmasi)
        $bookingsPerluKonfirmasi = Booking::with(['layanan', 'warga', 'petugas']) // Ambil relasi
                                    ->where('status_berkas', 'JANJI TEMU DIBUAT')
                                    ->orderBy('created_at', 'desc') // Tampilkan yang paling baru
                                    ->take(5) // Batasi 5
                                    ->get();

        // Ambil data statistik (dummy, bisa Anda kembangkan nanti)
        $totalLayanan = \App\Models\Layanan::count();
        $totalBookingHariIni = Booking::whereDate('created_at', today())->count();
        $totalPengumuman = \App\Models\Pengumuman::where('status', 'aktif')->count();

        return view('admin.dashboard', [
            'bookingsPerluKonfirmasi' => $bookingsPerluKonfirmasi,
            'totalLayanan' => $totalLayanan,
            'totalBookingHariIni' => $totalBookingHariIni,
            'totalPengumuman' => $totalPengumuman,
        ]);
    }
}