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
        Schema::create('warga', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16)->unique(); // NIK sebagai identifikasi utama
            $table->string('nama_lengkap');
            $table->string('no_hp')->nullable();
            $table->string('email')->nullable();
            $table->text('alamat_terakhir')->nullable(); // Alamat terakhir dari interaksi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warga');
    }
};