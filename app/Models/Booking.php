<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany; // <<< TAMBAHKAN INI
use App\Models\Warga; // <<< PASTIKAN INI ADA
use App\Models\User; // <<< PASTIKAN INI ADA
use App\Models\Layanan; // <<< PASTIKAN INI ADA
use App\Models\BookingStatusLog; // <<< TAMBAHKAN INI

class Booking extends Model
{
    use HasFactory;

    // Asumsi tabel Anda bernama 'booking'
    protected $table = 'booking'; 

    protected $fillable = [
        'no_booking',
        'warga_id',
        'layanan_id',
        'petugas_id',
        'jadwal_janji_temu',
        'status_berkas',
        'catatan_internal'
    ];

    protected $casts = [
        'jadwal_janji_temu' => 'datetime',
    ];

    /**
     * RELASI: Satu Booking DIMILIKI OLEH (belongsTo) Satu Layanan
     */
    public function layanan(): BelongsTo
    {
        return $this->belongsTo(Layanan::class);
    }

    /**
     * RELASI: Satu Booking DIMILIKI OLEH (belongsTo) Satu User (Petugas)
     */
    public function petugas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    // ===============================================
    // <<< TAMBAHKAN RELASI INI >>>
    // ===============================================
    /**
     * RELASI: Satu Booking DIMILIKI OLEH (belongsTo) Satu Warga
     */
    public function warga(): BelongsTo
    {
        return $this->belongsTo(Warga::class, 'warga_id');
    }
    
    /**
     * RELASI BARU: Satu Booking MEMILIKI BANYAK (hasMany) BookingStatusLog
     */
    public function statusLogs(): HasMany
    {
        return $this->hasMany(BookingStatusLog::class)->orderBy('created_at', 'desc');
    }

    /**
     * Untuk mendapatkan status terakhir/terkini dari booking melalui log
     */
    public function getLatestStatusAttribute()
    {
        return $this->statusLogs->first()->status ?? $this->status; // Ambil dari log terbaru, fallback ke kolom status
    }
}