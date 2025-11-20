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
        'deskripsi',
        'estimasi_proses',
        'biaya',
        'dasar_hukum',
        'status',
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
    
}