<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;     
use Illuminate\Support\Facades\Auth;     
use Illuminate\Validation\Rule;        
use Illuminate\Validation\Rules\Password; 

class PetugasController extends Controller
{
    // BENAR
    public function __construct()
    {
        // Gunakan middleware 'can' agar dijalankan pada waktu yang tepat
        $this->middleware('can:kelola-sistem'); 
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) // <<< Tambahkan Request $request
    {
        // 1. Mulai query dasar
        $query = User::query();

        // 2. Terapkan logika pencarian (search)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            // Cari di beberapa kolom
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', '%' . $search . '%')
                  ->orWhere('username', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        // 3. Ambil data dengan paginasi dan urutan
        $allPetugas = $query->orderBy('nama_lengkap', 'asc')
                             ->paginate(10)
                             ->withQueryString(); // <<< Agar paginasi tetap membawa filter search

        // 4. Kirim data ke view
        return view('admin.petugas.index', compact('allPetugas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Menampilkan view 'create' (form kosong)
        return view('admin.petugas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi data
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username', // Harus unik di tabel users
            'email' => 'required|string|email|max:255|unique:users,email', // Harus unik di tabel users
            'jabatan' => 'nullable|string|max:255',
            'role' => 'required|in:super_admin,petugas_layanan,pimpinan',
            'password' => ['required', 'confirmed', Password::min(8)], // Password minimal 8 karakter dan harus dikonfirmasi
        ]);

        // 2. Hash password sebelum disimpan
        $validated['password'] = Hash::make($validated['password']);

        // 3. Buat record user baru
        User::create($validated);

        // 4. Redirect kembali dengan pesan sukses
        return redirect()->route('admin.petugas.index')
                         ->with('success', 'Akun petugas baru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $petugas)
    {
        // Biasanya tidak digunakan di admin panel, kita fokus di 'edit'
        return redirect()->route('admin.petugas.edit', $petugas);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $petugas) // Menggunakan Route Model Binding
    {
        // Mengirim data user yang ada ke view 'edit' (form terisi)
        return view('admin.petugas.edit', compact('petugas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $petugas)
    {
        // 1. Validasi data
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users')->ignore($petugas->id), // Abaikan username user ini sendiri
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($petugas->id), // Abaikan email user ini sendiri
            ],
            'jabatan' => 'nullable|string|max:255',
            'role' => 'required|in:super_admin,petugas_layanan,pimpinan',
            'password' => ['nullable', 'confirmed', Password::min(8)], // Password opsional saat update
        ]);

        // 2. Handle password update (HANYA JIKA DIISI)
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            // Jika password tidak diisi, hapus dari data yang akan di-update
            unset($validated['password']);
        }

        // 3. Update record di database
        $petugas->update($validated);

        // 4. Redirect kembali dengan pesan sukses
        return redirect()->route('admin.petugas.index')
                         ->with('success', 'Akun petugas berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $petugas)
    {
        // Pencegahan: User tidak bisa menghapus akunnya sendiri
        if (Auth::id() == $petugas->id) {
            return redirect()->route('admin.petugas.index')
                             ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        try {
            $namaPetugas = $petugas->nama_lengkap;
            // 1. Hapus record dari database
            $petugas->delete();

            return redirect()->route('admin.petugas.index')
                             ->with('success', "Akun petugas '$namaPetugas' berhasil dihapus.");
                             
        } catch (\Exception $e) {
            // Tangani jika ada error (misal: foreign key constraint jika petugas terkait booking)
            \Illuminate\Support\Facades\Log::error('Gagal hapus petugas: ' . $e->getMessage());
            return redirect()->route('admin.petugas.index')
                             ->with('error', 'Gagal menghapus akun petugas. Akun ini mungkin masih terkait dengan data booking.');
        }
    }
}
