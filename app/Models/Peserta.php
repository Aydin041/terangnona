<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Peserta extends Authenticatable
{
    protected $table = 'peserta';

    protected $fillable = [
        'nama',
        'email',
        'kontak',
        'password_hash',
    ];

    protected $hidden = [
        'password_hash',
    ];

    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    public function pengajuan()
    {
        return $this->hasMany(Pengajuan::class);
    }
}