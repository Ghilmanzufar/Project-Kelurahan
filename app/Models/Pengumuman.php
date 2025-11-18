<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengumuman extends Model
{
    use HasFactory;

    /**
     * Tentukan nama tabel jika tidak sesuai konvensi Laravel
     */
    protected $table = 'pengumuman';

    /**
     * Kolom yang boleh diisi secara massal (untuk admin panel nanti)
     */
    protected $fillable = [
        'judul',
        'slug',
        'featured_image',
        'isi_konten',
        'kategori',
        'tanggal_publikasi',
        'file_pdf_path',
        'status',
        'user_id', // Penting untuk tahu siapa yang mempublikasikan
    ];

    /**
     * Memberitahu Laravel untuk memperlakukan kolom ini sebagai objek Tanggal (Carbon).
     * Ini akan membuat format tanggal di 'beranda.blade.php' bekerja sempurna.
     */
    protected $casts = [
        'tanggal_publikasi' => 'date',
    ];

    /**
     * RELASI: Satu Pengumuman DIMILIKI OLEH (belongsTo) Satu User (Petugas)
     */
    public function petugas(): BelongsTo
    {
        // 'User' adalah nama model default Laravel untuk tabel 'users'
        // Kita hubungkan 'user_id' di tabel 'pengumuman' ke 'id' di tabel 'users'
        return $this->belongsTo(User::class, 'user_id');
    }
}