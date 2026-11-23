<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class Admin extends Authenticatable
{
    protected $table = 'admin';

    protected $fillable = [
        'uuid',
        'nama',
        'email',
        'password_hash',
    ];

    protected $hidden = [
        'password_hash',
    ];

    protected static function booted()
    {
        static::creating(function ($admin) {
            if (empty($admin->uuid)) {
                $admin->uuid = (string) Str::uuid();
            }
        });
    }

    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    public function getAuthPasswordName()
    {
        return 'password_hash';
    }

    public function permintaanBukaKunciDiproses()
    {
        return $this->hasMany(PermintaanBukaKunci::class, 'admin_id');
    }
}
