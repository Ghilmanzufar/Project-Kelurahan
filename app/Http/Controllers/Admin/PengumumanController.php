<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <<< TAMBAHKAN INI (Untuk mencatat user_id)
use Illuminate\Support\Facades\Storage; // <<< TAMBAHKAN INI (Untuk upload/hapus file PDF)
use Illuminate\Support\Str;

class PengumumanController extends Controller
{
    public function __construct()
    {
        // Ganti authorize menjadi middleware can
        $this->middleware('can:kelola-konten');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) // <<< Tambahkan Request $request
    {
        // 1. Mulai query dasar (sudah ada)
        $query = Pengumuman::with('petugas');

        // 2. Terapkan logika pencarian (search)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            // Cari di kolom 'judul' ATAU 'kategori'
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('kategori', 'like', '%' . $search . '%');
            });
        }

        // 3. Terapkan logika filter status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // 4. Ambil data dengan paginasi dan urutan
        $allPengumuman = $query->orderBy('tanggal_publikasi', 'desc')
                                 ->paginate(10)
                                 ->withQueryString(); // <<< Agar paginasi tetap membawa filter

        // 5. Kirim data ke view
        return view('admin.pengumuman.index', compact('allPengumuman'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pengumuman = new Pengumuman(); // Buat instance kosong untuk form
        return view('admin.pengumuman.create', compact('pengumuman'));
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
            'featured_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', // Validasi gambar
            'file_pdf_path' => 'nullable|file|mimes:pdf|max:2048', // Validasi PDF
        ]);

        // 2. Tambahkan user_id dari admin yang sedang login
        $validated['user_id'] = Auth::id();

        // 3. Buat Slug unik
        $validated['slug'] = Str::slug($validated['judul']) . '-' . uniqid();

        // 4. Handle upload Gambar Utama (jika ada)
        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('pengumuman_images', 'public');
            $validated['featured_image'] = $path;
        }

        // 5. Handle upload File PDF (jika ada)
        if ($request->hasFile('file_pdf_path')) {
            $path = $request->file('file_pdf_path')->store('pengumuman_pdf', 'public');
            $validated['file_pdf_path'] = $path;
        }

        // 6. Buat record baru di database
        Pengumuman::create($validated);

        // 7. Redirect kembali dengan pesan sukses
        return redirect()->route('admin.pengumuman.index')
                         ->with('success', 'Pengumuman baru berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengumuman $pengumuman)
    {
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
            'featured_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'file_pdf_path' => 'nullable|file|mimes:pdf|max:2048',
            'hapus_gambar' => 'nullable|boolean', // Validasi checkbox
            'hapus_pdf' => 'nullable|boolean', // Validasi checkbox
        ]);

        // 2. Update slug jika judul berubah
        if ($request->judul != $pengumuman->judul) {
            $validated['slug'] = Str::slug($validated['judul']) . '-' . $pengumuman->id;
        }

        // 3. Handle upload/hapus Gambar Utama
        if ($request->hasFile('featured_image')) {
            // KASUS 1: UPLOAD GAMBAR BARU
            // Hapus file lama jika ada
            if ($pengumuman->featured_image) {
                Storage::disk('public')->delete($pengumuman->featured_image);
            }
            // Simpan file baru
            $path = $request->file('featured_image')->store('pengumuman_images', 'public');
            $validated['featured_image'] = $path;

        } elseif ($request->input('hapus_gambar')== '1') {
            // KASUS 2: HAPUS GAMBAR (Checkbox dicentang)
            // Hapus file lama dari storage
            if ($pengumuman->featured_image) {
                Storage::disk('public')->delete($pengumuman->featured_image);
            }
            // Set kolom di database menjadi null
            $validated['featured_image'] = null;
        }
        // KASUS 3: Tidak melakukan apa-apa pada gambar (tidak ada file baru, checkbox tidak dicentang)

        // 4. Handle upload/hapus File PDF
        if ($request->hasFile('file_pdf_path')) {
            // KASUS 1: UPLOAD PDF BARU
            if ($pengumuman->file_pdf_path) {
                Storage::disk('public')->delete($pengumuman->file_pdf_path);
            }
            $path = $request->file('file_pdf_path')->store('pengumuman_pdf', 'public');
            $validated['file_pdf_path'] = $path;

        } elseif ($request->input('hapus_pdf')== '1') {
            // KASUS 2: HAPUS PDF (Checkbox dicentang)
            if ($pengumuman->file_pdf_path) {
                Storage::disk('public')->delete($pengumuman->file_pdf_path);
            }
            $validated['file_pdf_path'] = null;
        }
        
        // 5. Update record di database
        // Kita perlu menghapus 'hapus_gambar' dan 'hapus_pdf' dari array $validated
        // karena kolom itu tidak ada di database
        unset($validated['hapus_gambar']);
        unset($validated['hapus_pdf']);
        
        $pengumuman->update($validated);

        // 6. Redirect kembali dengan pesan sukses
        return redirect()->route('admin.pengumuman.index')
                         ->with('success', 'Pengumuman berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengumuman $pengumuman)
    {
        try {
            $namaJudul = $pengumuman->judul; // Simpan nama untuk pesan sukses
            
            // 1. Hapus file Gambar Utama dari storage (jika ada)
            if ($pengumuman->featured_image) {
                Storage::disk('public')->delete($pengumuman->featured_image);
            }
            
            // 2. Hapus file PDF terkait dari storage (jika ada)
            if ($pengumuman->file_pdf_path) {
                Storage::disk('public')->delete($pengumuman->file_pdf_path);
            }

            // 3. Hapus record dari database
            $pengumuman->delete();

            return redirect()->route('admin.pengumuman.index')
                             ->with('success', "Pengumuman '$namaJudul' berhasil dihapus.");
                             
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Gagal hapus pengumuman: ' . $e->getMessage()); // Catat error
            return redirect()->route('admin.pengumuman.index')
                             ->with('error', 'Gagal menghapus pengumuman: ' . $e->getMessage());
        }
    }
}