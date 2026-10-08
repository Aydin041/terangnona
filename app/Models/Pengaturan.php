<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    protected $table = 'pengaturan';

    protected $fillable = [
        'deadline_pengajuan',
        'minimal_juri_submit',
    ];

    protected $casts = [
        'deadline_pengajuan' => 'datetime',
        'minimal_juri_submit' => 'integer',
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

    /**
     * Jumlah minimal Juri yang harus submit final sebelum nilai dihitung.
     * Diatur Admin; nilai awal 2. Tidak pernah kurang dari 1.
     */
    public static function minimalJuriSubmit(): int
    {
        $nilai = (int) (self::ambil()->minimal_juri_submit ?? 2);

        return max(1, $nilai);
    }
}