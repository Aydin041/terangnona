<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IsianProposalLink extends Model
{
    protected $table = 'isian_proposal_link';

    protected $fillable = [
        'isian_proposal_id',
        'judul',
        'link',
    ];

    public function isianProposal()
    {
        return $this->belongsTo(IsianProposal::class);
    }
}