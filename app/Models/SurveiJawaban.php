<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Jawaban survei. Sengaja TIDAK punya hubungan ke peserta, tidak punya waktu,
 * dan memakai ID acak, supaya satu jawaban tidak bisa ditelusuri ke pengisinya.
 */
class SurveiJawaban extends Model
{
    protected $table = 'survei_jawaban';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = ['nilai', 'aspek', 'saran'];

    protected $casts = [
        'nilai' => 'integer',
        'aspek' => 'array',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $jawaban) {
            if (empty($jawaban->id)) {
                $jawaban->id = (string) Str::uuid();
            }
        });
    }
}