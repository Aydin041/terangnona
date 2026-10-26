<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Panitia extends Authenticatable
{
    protected $table = 'panitia';

    protected $fillable = [
        'nama',
        'email',
        'password_hash',
    ];

    protected $hidden = [
        'password_hash',
    ];

    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    public function getAuthPasswordName()
    {
        return 'password_hash';
    }

    public function riwayatStatus()
    {
        return $this->hasMany(RiwayatStatus::class);
    }
}