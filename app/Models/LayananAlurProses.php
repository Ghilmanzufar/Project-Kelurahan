<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LayananAlurProses extends Model
{
    use HasFactory;

    protected $table = 'layanan_alur_proses';

    protected $fillable = [
        'layanan_id',
        'deskripsi_alur',
    ];

    /**
     * RELASI: Satu Alur Proses DIMILIKI OLEH (belongsTo) Satu Layanan
     */
    public function layanan(): BelongsTo
    {
        return $this->belongsTo(Layanan::class);
    }
}