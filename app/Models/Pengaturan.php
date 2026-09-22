<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    protected $table = 'pengaturan';

    protected $fillable = [
        'deadline_pengajuan',
    ];

    protected $casts = [
        'deadline_pengajuan' => 'datetime',
    ];

    public static function ambil(): self
    {
        return self::firstOrCreate(['id' => 1]);
    }

    public static function sudahLewatDeadline(): bool
    {
        $deadline = self::ambil()->deadline_pengajuan;

        return $deadline !== null && now()->greaterThan($deadline);
    }
}