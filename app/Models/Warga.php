<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // <<< TAMBAHKAN INI

class Warga extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'warga'; // Nama tabel yang sebenarnya adalah 'warga' (tanpa 's')

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nik',
        'nama_lengkap',
        'tanggal_lahir', 
        'no_hp',
        'email',
        'alamat_terakhir',
    ];

    // ===============================================
    // <<< TAMBAHKAN BLOK INI >>>
    // ===============================================
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_lahir' => 'date', // Otomatis ubah 'tanggal_lahir' menjadi objek Carbon (date)
    ];
    // ===============================================

    /**
     * RELASI BARU: Satu Warga memiliki BANYAK (hasMany) Booking
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'warga_id');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        // Biasanya tidak ada yang disembunyikan untuk warga,
        // kecuali jika ada password yang tidak Anda sebutkan di migrasi.
        // 'password',
    ];
}