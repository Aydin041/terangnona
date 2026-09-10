<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubmissionProposal extends Model
{
    protected $table = 'submission_proposal';

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

    public function nilaiKomponen()
    {
        return $this->hasMany(NilaiKomponenProposal::class, 'submission_id');
    }
}