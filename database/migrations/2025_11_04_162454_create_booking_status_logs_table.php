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
        Schema::create('booking_status_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('booking')->onDelete('cascade');
            $table->string('status'); // Contoh: 'JANJI TEMU DIBUAT', 'BERKAS DITERIMA', 'VERIFIKASI BERKAS', 'SEDANG DIPROSES', 'SELESAI'
            $table->text('deskripsi')->nullable(); // Deskripsi detail untuk status ini
            $table->string('petugas_id')->nullable(); // Jika ada petugas yang mengupdate status (opsional)
            $table->timestamps(); // created_at (kapan status ini dibuat)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_status_logs');
    }
};