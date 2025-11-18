<?php

namespace App\Http\Controllers;

use App\Models\PesanKontak;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Menampilkan halaman 'Kontak Kami'.
     */
    public function kontak()
    {
        return view('kontak'); // Ini akan me-render file resources/views/kontak.blade.php
    }

    public function storeKontak(Request $request)
    {
        // 1. Validasi Input (Sesuai name="" di HTML)
        $validated = $request->validate([
            'first-name' => 'required|string|max:255', // Sesuai input HTML
            'last-name' => 'required|string|max:255',  // Sesuai input HTML
            'email' => 'required|email|max:255',
            'message' => 'required|string',            // Sesuai input HTML
        ]);

        // 2. Simpan ke Database (Mapping manual)
        // Kiri: Nama Kolom Database | Kanan: Data dari Form ($validated)
        PesanKontak::create([
            'nama_depan'    => $validated['first-name'], // Ambil dari 'first-name'
            'nama_belakang' => $validated['last-name'],  // Ambil dari 'last-name'
            'email'         => $validated['email'],
            'pesan'         => $validated['message'],    // Ambil dari 'message'
        ]);

        // 3. Kembali dengan pesan sukses
        return back()->with('success', 'Pesan Anda berhasil dikirim! Kami akan segera menghubungi Anda.');
    }
}