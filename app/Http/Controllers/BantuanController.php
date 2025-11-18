<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BantuanController extends Controller
{
    public function index()
    {
        // Baca file JSON
        $path = public_path('knowledge_base.json');
        
        if (!File::exists($path)) {
            abort(404, 'File knowledge base tidak ditemukan.');
        }

        $json = File::get($path);
        $data = json_decode($json, true);

        // Ambil data FAQ
        $faqData = $data['data'] ?? [];

        return view('bantuan.index', compact('faqData'));
    }
}