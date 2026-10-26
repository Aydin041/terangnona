<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Pimpinan extends Authenticatable
{
    protected $table = 'pimpinan';

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
}