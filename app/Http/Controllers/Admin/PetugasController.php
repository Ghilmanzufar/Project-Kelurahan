<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash; // Untuk hash password nanti
use Illuminate\Support\Facades\Auth; // Untuk cek user_id
use Illuminate\Validation\Rule;

class PetugasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Ambil semua data user, urutkan berdasarkan nama
        $allPetugas = User::orderBy('nama_lengkap', 'asc')->paginate(10); // Paginasi 10 per halaman

        // Kirim data ke view
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
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
            'password' => 'required|string|min:8|confirmed', // Password minimal 8 karakter dan harus dikonfirmasi
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
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $petugas)
    {
        // 1. Validasi data
        // Untuk update, password tidak wajib diisi jika tidak ingin diubah
        // Email dan username harus unik, tapi abaikan user yang sedang diedit
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
            'password' => 'nullable|string|min:8|confirmed', // Password opsional saat update
        ]);

        // 2. Handle password update
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            // Jika password tidak diisi, hapus dari data yang divalidasi
            // Agar tidak meng-update password menjadi null
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
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $petugas)
    {
        // Pencegahan: User tidak bisa menghapus akunnya sendiri
        if (Auth::id() == $petugas->id) {
            return redirect()->route('admin.petugas.index')
                             ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        try {
            // 1. Hapus record dari database
            $petugas->delete();

            return redirect()->route('admin.petugas.index')
                             ->with('success', 'Akun petugas berhasil dihapus.');
                             
        } catch (\Exception $e) {
            // Tangani jika ada error (misal: foreign key constraint)
            return redirect()->route('admin.petugas.index')
                             ->with('error', 'Gagal menghapus akun petugas: ' . $e->getMessage());
        }
    }
}
