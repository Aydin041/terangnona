<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NilaiAspekPresentasi extends Model
{
    protected $table = 'nilai_aspek_presentasi';

    public $timestamps = false;

    protected $fillable = [
        'submission_id',
        'aspek',
        'nilai',
        'catatan',
        'terkunci',
    ];

    protected $casts = [
        'terkunci' => 'boolean',
    ];

    public function submission()
    {
        return $this->belongsTo(SubmissionPresentasi::class, 'submission_id');
    }
}