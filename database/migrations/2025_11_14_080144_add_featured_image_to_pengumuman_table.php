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
        Schema::table('pengumuman', function (Blueprint $table) {
            // Tambah kolom 'featured_image' setelah kolom 'kategori'
            // nullable() artinya boleh kosong
            $table->string('featured_image')->nullable()->after('kategori');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengumuman', function (Blueprint $table) {
            // Hapus kolom 'featured_image' jika migrasi di-rollback
            $table->dropColumn('featured_image');
        });
    }
};
