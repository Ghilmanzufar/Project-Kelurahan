<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <<< TAMBAHKAN INI (Untuk mencatat user_id)
use Illuminate\Support\Facades\Storage; // <<< TAMBAHKAN INI (Untuk upload/hapus file PDF)

class PengumumanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allPengumuman = Pengumuman::orderBy('tanggal_publikasi', 'desc')->paginate(10);
        return view('admin.pengumuman.index', compact('allPengumuman'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Menampilkan view 'create' (form kosong)
        return view('admin.pengumuman.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi data dari form
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'tanggal_publikasi' => 'required|date',
            'status' => 'required|in:aktif,draft,tidak_aktif',
            'isi_konten' => 'required|string',
            'file_pdf_path' => 'nullable|file|mimes:pdf|max:2048', // Opsional, maks 2MB
        ]);

        // 2. Tambahkan user_id dari admin yang sedang login
        $validated['user_id'] = Auth::id();

        // 3. Handle file upload (jika ada)
        if ($request->hasFile('file_pdf_path')) {
            // Simpan file di storage/app/public/pengumuman_pdf
            // 'pengumuman_pdf' adalah foldernya, 'public' adalah disk-nya
            $path = $request->file('file_pdf_path')->store('pengumuman_pdf', 'public');
            $validated['file_pdf_path'] = $path;
        }

        // 4. Buat record baru di database
        Pengumuman::create($validated);

        // 5. Redirect kembali dengan pesan sukses
        return redirect()->route('admin.pengumuman.index')
                         ->with('success', 'Pengumuman baru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengumuman $pengumuman)
    {
        // Biasanya tidak digunakan di admin panel, kita fokus di 'edit'
        return redirect()->route('admin.pengumuman.edit', $pengumuman);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengumuman $pengumuman) // Menggunakan Route Model Binding
    {
        // Mengirim data pengumuman yang ada ke view 'edit' (form terisi)
        return view('admin.pengumuman.edit', compact('pengumuman'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengumuman $pengumuman)
    {
        // 1. Validasi data
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'tanggal_publikasi' => 'required|date',
            'status' => 'required|in:aktif,draft,tidak_aktif',
            'isi_konten' => 'required|string',
            'file_pdf_path' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        // 2. Handle file upload (jika ada file baru)
        if ($request->hasFile('file_pdf_path')) {
            // Hapus file lama jika ada
            if ($pengumuman->file_pdf_path) {
                Storage::disk('public')->delete($pengumuman->file_pdf_path);
            }
            // Simpan file baru
            $path = $request->file('file_pdf_path')->store('pengumuman_pdf', 'public');
            $validated['file_pdf_path'] = $path;
        }

        // 3. Update record di database
        $pengumuman->update($validated);

        // 4. Redirect kembali dengan pesan sukses
        return redirect()->route('admin.pengumuman.index')
                         ->with('success', 'Pengumuman berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengumuman $pengumuman)
    {
        try {
            // 1. Hapus file PDF terkait dari storage (jika ada)
            if ($pengumuman->file_pdf_path) {
                Storage::disk('public')->delete($pengumuman->file_pdf_path);
            }

            // 2. Hapus record dari database
            $pengumuman->delete();

            return redirect()->route('admin.pengumuman.index')
                             ->with('success', 'Pengumuman berhasil dihapus.');
                             
        } catch (\Exception $e) {
            // Tangani jika ada error (misal: foreign key constraint)
            return redirect()->route('admin.pengumuman.index')
                             ->with('error', 'Gagal menghapus pengumuman: ' . $e->getMessage());
        }
    }
}