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
    /**
     * Menampilkan daftar semua layanan (dengan fitur pencarian).
     */
    public function index(Request $request)
    {
        // Mulai query
        $query = Layanan::where('status', 'aktif');

        // Jika ada input pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_layanan', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $search . '%');
            });
        }

        // Ambil data (diurutkan nama)
        $layanan = $query->orderBy('nama_layanan')->get();

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