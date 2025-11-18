<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; 

class Layanan extends Model
{
    use HasFactory;

    protected $table = 'layanan'; // Pastikan nama tabel benar
    protected $guarded = ['id']; // Gunakan guarded agar lebih aman

    // Atribut yang dapat diisi secara massal
    protected $fillable = [
        'nama_layanan',
        'slug', // Pastikan kolom slug ada di tabel Anda
        'deskripsi_singkat',
        'info_tambahan',
        'biaya',
        'estimasi_waktu',
        'dasar_hukum',
        'status', // status aktif/nonaktif layanan
    ];

    // Relasi ke Booking
    // Sebuah Layanan bisa memiliki banyak Booking
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'layanan_id'); // Pastikan 'layanan_id' adalah foreign key di tabel bookings
    }

    // Relasi ke Dokumen Wajib
    // Sebuah Layanan bisa memiliki banyak Dokumen Wajib
    public function dokumenWajib()
    {
        return $this->hasMany(LayananDokumenWajib::class, 'layanan_id');
    }

    // Relasi ke Alur Proses
    // Sebuah Layanan bisa memiliki banyak Alur Proses
    public function alurProses()
    {
        return $this->hasMany(LayananAlurProses::class, 'layanan_id');
    }
    
    // Mutator untuk menghasilkan slug secara otomatis
    protected static function booted()
    {
        static::creating(function ($layanan) {
            $layanan->slug = Str::slug($layanan->nama_layanan);
        });

        static::updating(function ($layanan) {
            $layanan->slug = Str::slug($layanan->nama_layanan);
        });
    }
}