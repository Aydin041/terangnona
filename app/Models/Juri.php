<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class Juri extends Authenticatable
{
    protected static function booted(): void
    {
        static::creating(function (self $model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    protected $table = 'juri';

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

    public function submissionProposal()
    {
        return $this->hasMany(SubmissionProposal::class);
    }

    public function submissionPresentasi()
    {
        return $this->hasMany(SubmissionPresentasi::class);
    }

    public function permintaanBukaKunci()
    {
        return $this->hasMany(PermintaanBukaKunci::class);
    }
}