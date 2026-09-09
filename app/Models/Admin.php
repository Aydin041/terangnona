<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'admin';

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

    public function permintaanBukaKunciDiproses()
    {
        return $this->hasMany(PermintaanBukaKunci::class, 'admin_id');
    }
}