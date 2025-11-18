<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // Import model User
use Illuminate\Support\Facades\Hash; // Import Hash

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ===============================================
        // <<< TAMBAHKAN USER ADMIN INI >>>
        // ===============================================
        User::create([
            'nama_lengkap' => 'Super Admin Klender',
            'username' => 'superadmin', // Username untuk login
            'jabatan' => 'superadmin',
            'role' => 'super_admin', // Role sesuai rencana kita
            'status' => 'aktif',
            'email' => 'superadmin@example.com', // Email (bisa apa saja, karena kita login pakai username)
            'password' => Hash::make('password123'), // Password yang mudah diingat
        ]);

        // (Opsional) Tambahkan Pimpinan dan Petugas Layanan
        User::create([
            'nama_lengkap' => 'Petugas Layanan',
            'username' => 'petugas', 
            'jabatan' => 'Staff Pelayanan',
            'role' => 'petugas_layanan', // Pastikan string ini SAMA PERSIS dengan di ENUM
            'status' => 'aktif',
            'email' => 'petugas@example.com',
            'password' => Hash::make('password123'), 
        ]);
        User::create([
            'nama_lengkap' => 'Pimpinan Klender',
            'username' => 'pimpinan', 
            'jabatan' => 'Lurah',
            'role' => 'pimpinan', // Pastikan string ini SAMA PERSIS dengan di ENUM
            'status' => 'aktif',
            'email' => 'pimpinan@example.com',
            'password' => Hash::make('password123'), 
        ]);
    }
}