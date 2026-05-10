<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'no_hp',
        'agama',
        'pendidikan_terakhir',
        'pekerjaan',
        'golongan_darah',
        'profil_lengkap',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class);
    }
}