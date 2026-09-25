<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IsianProposal extends Model
{
    protected $table = 'isian_proposal';

    protected $fillable = [
        'pengajuan_id',
        'komponen_id',
        'uraian',
    ];

    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class);
    }

    public function komponen()
    {
        return $this->belongsTo(KomponenPenilaian::class, 'komponen_id');
    }

    public function links()
    {
        return $this->hasMany(IsianProposalLink::class, 'isian_proposal_id');
    }
}