<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengumuman::where('status', 'aktif');

        // Fitur Pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('isi_konten', 'like', '%' . $search . '%')
                  ->orWhere('kategori', 'like', '%' . $search . '%');
            });
        }

        // Urutkan dari yang terbaru
        $pengumuman = $query->orderBy('tanggal_publikasi', 'desc')
                            ->paginate(9) // Tampilkan 9 berita per halaman
                            ->withQueryString(); // Agar search tidak hilang saat pindah halaman

        return view('pengumuman.index', compact('pengumuman'));
    }

    public function show(Pengumuman $pengumuman)
    {
        // Pastikan hanya pengumuman aktif yang bisa dibuka
        if ($pengumuman->status !== 'aktif') {
            abort(404);
        }

        // Ambil berita terkait (opsional, untuk sidebar nanti)
        $beritaTerkait = Pengumuman::where('status', 'aktif')
                            ->where('id', '!=', $pengumuman->id)
                            ->where('kategori', $pengumuman->kategori)
                            ->take(3)
                            ->get();

        return view('pengumuman.show', compact('pengumuman', 'beritaTerkait'));
    }
}