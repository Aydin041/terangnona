<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NilaiKomponenProposal extends Model
{
    protected $table = 'nilai_komponen_proposal';

    public $timestamps = false;

    protected $fillable = [
        'submission_id',
        'komponen_id',
        'nilai',
        'komentar',
        'terkunci',
    ];

    protected $casts = [
        'terkunci' => 'boolean',
    ];

    public function submission()
    {
        return $this->belongsTo(SubmissionProposal::class, 'submission_id');
    }

    public function komponen()
    {
        return $this->belongsTo(KomponenPenilaian::class, 'komponen_id');
    }
}