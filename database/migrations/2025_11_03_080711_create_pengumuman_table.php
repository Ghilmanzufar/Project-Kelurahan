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
        Schema::create('pengumuman', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->longText('isi_konten'); // Menggunakan longText untuk Rich Text Editor
            $table->string('kategori');
            $table->date('tanggal_publikasi');
            $table->string('file_pdf_path')->nullable(); // Path ke file PDF
            $table->enum('status', ['aktif', 'draft', 'tidak_aktif'])->default('draft');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengumuman');
    }
};