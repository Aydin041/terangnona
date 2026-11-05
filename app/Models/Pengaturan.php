<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    protected $table = 'pengaturan';

    protected $fillable = [
        'deadline_pengajuan',
        'minimal_juri_submit',
        'survei_dibuka_pada',
        'survei_ditutup_pada',
    ];

    protected $casts = [
        'deadline_pengajuan' => 'datetime',
        'minimal_juri_submit' => 'integer',
        'survei_dibuka_pada' => 'datetime',
        'survei_ditutup_pada' => 'datetime',
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

    /**
     * Status survei menurut waktu sekarang:
     * 'tidak_aktif' (waktu buka/tutup kosong), 'belum_dibuka', 'dibuka', atau 'ditutup'.
     */
    public static function statusSurvei(): string
    {
        $pengaturan = self::ambil();

        if ($pengaturan->survei_dibuka_pada === null || $pengaturan->survei_ditutup_pada === null) {
            return 'tidak_aktif';
        }

        if (now()->lessThan($pengaturan->survei_dibuka_pada)) {
            return 'belum_dibuka';
        }

        if (now()->greaterThan($pengaturan->survei_ditutup_pada)) {
            return 'ditutup';
        }

        return 'dibuka';
    }
}