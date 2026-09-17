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
        'link_bukti_dukung',
    ];

    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class);
    }

    public function komponen()
    {
        return $this->belongsTo(KomponenPenilaian::class, 'komponen_id');
    }
}