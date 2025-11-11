<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    /**
     * Menampilkan daftar semua layanan.
     * (Sesuai dengan mockup Halaman Utama: Daftar Layanan di sisi Warga)
     */
    public function index()
    {
        // Mengambil semua data layanan yang berstatus 'aktif'
        // dan mengurutkannya berdasarkan nama
        $layanan = Layanan::where('status', 'aktif')->orderBy('nama_layanan')->get();

        // Mengirim data layanan ke view 'layanan.index'
        return view('layanan.index', compact('layanan'));
    }

    /**
     * Menampilkan detail satu layanan berdasarkan ID.
     * (Sesuai dengan mockup Halaman Jenis Layanan (Detail) di sisi Warga)
     */
    public function show(Layanan $layanan) // Laravel akan otomatis menemukan Layanan berdasarkan ID dari URL
    {
        // Pastikan layanan yang diminta berstatus 'aktif'
        if ($layanan->status !== 'aktif') {
            abort(404); // Tampilkan halaman 404 jika layanan tidak aktif
        }

        // Memuat relasi 'dokumenWajib' dan 'alurProses' bersamaan dengan data layanan utama
        // Ini adalah kehebatan Eloquent Relationships!
        $layanan->load('dokumenWajib', 'alurProses');

        // Mengirim data layanan (dengan dokumen dan alur yang sudah dimuat) ke view 'layanan.show'
        return view('layanan.show', compact('layanan'));
    }
}