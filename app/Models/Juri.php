<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Juri extends Authenticatable
{
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