<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PesanKontak;
use Illuminate\Http\Request;

class PesanController extends Controller
{
    public function __construct()
    {
        // Kita gunakan gate 'kelola-konten' (Super Admin & Petugas Layanan)
        // atau 'kelola-sistem' jika hanya Super Admin.
        $this->middleware('can:kelola-konten'); 
    }

    public function index()
    {
        $pesan = PesanKontak::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.pesan.index', compact('pesan'));
    }

    public function destroy($id)
    {
        $pesan = PesanKontak::findOrFail($id);
        $pesan->delete();
        return back()->with('success', 'Pesan berhasil dihapus.');
    }
}