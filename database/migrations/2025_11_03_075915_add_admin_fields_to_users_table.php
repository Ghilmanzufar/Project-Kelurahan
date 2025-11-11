<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Kolom tambahan untuk admin/petugas
            $table->string('username')->unique()->after('name'); // Harus unik
            $table->string('jabatan')->nullable()->after('username');
            $table->enum('role', ['super_admin', 'petugas_layanan', 'pimpinan'])->default('petugas_layanan')->after('jabatan');
            $table->enum('status', ['aktif', 'tidak_aktif'])->default('aktif')->after('role');
            
            // Mengubah 'name' menjadi 'nama_lengkap' agar lebih sesuai
            $table->renameColumn('name', 'nama_lengkap');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Balikkan perubahan jika migrasi di-rollback
            $table->dropColumn(['username', 'jabatan', 'role', 'status']);
            $table->renameColumn('nama_lengkap', 'name'); // Balikkan nama kolom
        });
    }
};