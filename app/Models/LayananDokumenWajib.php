<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LayananDokumenWajib extends Model
{
    use HasFactory;

    protected $table = 'layanan_dokumen_wajib';

    protected $fillable = [
        'layanan_id',
        'deskripsi_dokumen',
    ];

    /**
     * RELASI: Satu Dokumen Wajib DIMILIKI OLEH (belongsTo) Satu Layanan
     */
    public function layanan(): BelongsTo
    {
        return $this->belongsTo(Layanan::class);
    }
}