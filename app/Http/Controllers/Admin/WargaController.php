<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Warga;
use Illuminate\Validation\Rule; // <<< TAMBAHKAN INI

class WargaController extends Controller
{
    public function index(Request $request)
    {
        // Logika pencarian
        $query = Warga::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('nama_lengkap', 'like', '%' . $search . '%')
                  ->orWhere('nik', 'like', '%' . $search . '%')
                  ->orWhere('no_hp', 'like', '%' . $search . '%');
        }

        // Ambil semua data warga (dengan hasil pencarian jika ada), urutkan berdasarkan nama
        $allWarga = $query->orderBy('nama_lengkap', 'asc')->paginate(10)->withQueryString();

        // Kirim data ke view
        return view('admin.warga.index', compact('allWarga'));
    }

    public function edit(Warga $warga) // Menggunakan Route Model Binding
    {
        // Mengirim data warga yang ada ke view 'edit' (form terisi)
        return view('admin.warga.edit', compact('warga'));
    }

    public function update(Request $request, Warga $warga)
    {
        // 1. Validasi data
        // NIK dan email harus unik, tapi abaikan warga yang sedang diedit
        $validated = $request->validate([
            'nik' => [
                'required',
                'string',
                'max:255',
                Rule::unique('warga')->ignore($warga->id), // Abaikan NIK warga ini sendiri
            ],
            'nama_lengkap' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'no_hp' => 'required|string|max:20',
            'email' => [
                'nullable', // Email bisa kosong
                'string',
                'email',
                'max:255',
                Rule::unique('warga')->ignore($warga->id), // Abaikan email warga ini sendiri
            ],
            'alamat' => 'nullable|string|max:1000',
        ]);

        // 2. Update record di database
        $warga->update($validated);

        // 3. Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('admin.warga.index')
                         ->with('success', 'Data warga berhasil diperbarui.');
    }
}
