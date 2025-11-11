<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Layanan extends Model
{
    use HasFactory;

    /**
     * Tentukan nama tabel jika tidak sesuai konvensi Laravel (opsional, tapi bagus)
     */
    protected $table = 'layanan';

    /**
     * Kolom yang boleh diisi secara massal (untuk admin panel nanti)
     */
    protected $fillable = [
        'nama_layanan',
        'deskripsi',
        'estimasi_proses',
        'biaya',
        'dasar_hukum',
        'status',
    ];

    /**
     * RELASI: Satu Layanan memiliki BANYAK Dokumen Wajib
     */
    public function dokumenWajib(): HasMany
    {
        return $this->hasMany(LayananDokumenWajib::class);
    }

    /**
     * RELASI: Satu Layanan memiliki BANYAK Alur Proses
     */
    public function alurProses(): HasMany
    {
        return $this->hasMany(LayananAlurProses::class);
    }
}