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
        Schema::create('booking', function (Blueprint $table) {
            $table->id();
            $table->string('no_booking')->unique(); // Nomor booking unik
            $table->foreignId('warga_id')->constrained('warga')->onDelete('cascade'); // FK ke tabel 'warga'
            $table->foreignId('layanan_id')->constrained('layanan')->onDelete('cascade'); // FK ke tabel 'layanan'
            $table->foreignId('petugas_id')->nullable()->constrained('users')->onDelete('set null'); // FK ke tabel 'users', bisa null jika belum ditunjuk
            $table->dateTime('jadwal_janji_temu');
            $table->string('status_berkas'); // Contoh: "Menunggu Konfirmasi", "Berkas Diterima", "Selesai"
            $table->text('catatan_internal')->nullable(); // Catatan untuk admin
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking');
    }
};