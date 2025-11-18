<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Pengumuman;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman Beranda (Homepage)
     */
    public function index()
    {
        // 1. Mengambil 3 Layanan (Contoh: kita ambil 3 layanan 'aktif' pertama)
        // Anda bisa kustomisasi logikanya nanti (misal: berdasarkan popularitas)
        $layananPopuler = Layanan::where('status', 'aktif')
                                  ->orderBy('created_at', 'desc') // Asumsi yang baru yang populer
                                  ->take(3)
                                  ->get();

        // 2. Mengambil 2 Pengumuman terbaru
        $pengumumanTerbaru = Pengumuman::where('status', 'aktif')
                                        ->orderBy('tanggal_publikasi', 'desc')
                                        ->take(6)
                                        ->get();

        // 3. Mengirim data ke view 'beranda'
        return view('beranda', [
            'layananPopuler' => $layananPopuler,
            'pengumumanTerbaru' => $pengumumanTerbaru,
        ]);
    }

    public function kontak()
    {
        return view('kontak.index');
    }
}