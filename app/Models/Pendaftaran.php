<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    protected $table = 'pendaftaran';

    protected $fillable = [
        'user_id',
        'dokter_id',
        'nama_pasien',
        'nik_pasien',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'no_hp',
        'agama',
        'pendidikan_terakhir',
        'pekerjaan',
        'golongan_darah',
        'tanggal_kunjungan',
        'keluhan',
        'nomor_antrian',
        'untuk',
        'status',
    ];

    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}