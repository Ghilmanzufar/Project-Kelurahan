<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    /**
     * Menampilkan daftar semua pengumuman (dengan paginasi dan pencarian).
     */
    public function index(Request $request)
    {
        // Ambil query pencarian dari URL (misal: /pengumuman?search=pajak)
        $query = $request->input('search');

        $pengumuman = Pengumuman::where('status', 'aktif')
            ->when($query, function ($q) use ($query) {
                // Jika ada query pencarian, cari di judul atau isi konten
                $q->where('judul', 'like', '%' . $query . '%')
                  ->orWhere('isi_konten', 'like', '%' . $query . '%');
            })
            ->orderBy('tanggal_publikasi', 'desc') // Tampilkan yang terbaru di atas
            ->paginate(5); // Tampilkan 5 pengumuman per halaman

        return view('pengumuman.index', compact('pengumuman', 'query'));
    }

    /**
     * Menampilkan detail satu pengumuman.
     */
    public function show(Pengumuman $pengumuman) // Menggunakan Route Model Binding
    {
        // Jika warga mencoba mengakses URL pengumuman yang belum 'aktif'
        if ($pengumuman->status !== 'aktif') {
            abort(404);
        }

        return view('pengumuman.show', compact('pengumuman'));
    }
}