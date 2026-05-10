<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    protected $table = 'dokter';
    
    protected $fillable = [
        'nama',
        'spesialisasi',
        'hari_praktik',
        'jam_praktik',
        'kuota_per_hari',
        'status',
    ];
}