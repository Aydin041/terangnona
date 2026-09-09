<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatStatus extends Model
{
    protected $table = 'riwayat_status';

    public $timestamps = false;

    protected $fillable = [
        'pengajuan_id',
        'status',
        'catatan_panitia',
        'panitia_id',
        'changed_at',
    ];

    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class);
    }

    public function panitia()
    {
        return $this->belongsTo(Panitia::class);
    }
}