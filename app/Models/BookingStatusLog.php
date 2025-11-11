<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingStatusLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'status',
        'deskripsi',
        'petugas_id',
    ];

    /**
     * RELASI: Satu BookingStatusLog DIMILIKI OLEH (belongsTo) Satu Booking
     */
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * RELASI: Satu BookingStatusLog DIMILIKI OLEH (belongsTo) Satu User (Petugas)
     */
    public function petugas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }
}