<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Catatan bahwa seorang peserta sudah mengisi survei.
 * Sengaja tidak memuat jawaban maupun waktu pengisian.
 */
class SurveiPartisipasi extends Model
{
    protected $table = 'survei_partisipasi';

    public $timestamps = false;

    protected $fillable = ['peserta_id'];
}