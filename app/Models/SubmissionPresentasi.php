<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubmissionPresentasi extends Model
{
    protected $table = 'submission_presentasi';

    public $timestamps = false;

    protected $fillable = [
        'pengajuan_id',
        'juri_id',
        'status',
        'submitted_at',
    ];

    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class);
    }

    public function juri()
    {
        return $this->belongsTo(Juri::class);
    }

    public function nilaiAspek()
    {
        return $this->hasMany(NilaiAspekPresentasi::class, 'submission_id');
    }
}