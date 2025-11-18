<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesanKontak extends Model
{
    use HasFactory;

    // Pastikan fillable sesuai dengan nama KOLOM DATABASE
    protected $fillable = [
        'nama_depan',
        'nama_belakang',
        'email',
        'pesan',
    ];
}