<?php

namespace App\Http\Controllers;

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

    /**
     * Anda bisa menambahkan method lain di sini untuk halaman statis lainnya.
     * Contoh:
     * public function tentangKami()
     * {
     * return view('tentang-kami');
     * }
     *
     * public function faq()
     * {
     * return view('faq');
     * }
     */
}