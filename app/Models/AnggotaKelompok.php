<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggotaKelompok extends Model
{
    protected $table = 'anggota_kelompok';

    protected $fillable = [
        'pengajuan_id',
        'nama',
        'kontak',
        'adalah_ketua',
    ];

    protected $casts = [
        'adalah_ketua' => 'boolean',
    ];

    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class);
    }
}