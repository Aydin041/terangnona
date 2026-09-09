<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    protected $table = 'dokumen';

    public $timestamps = false;

    protected $fillable = [
        'pengajuan_id',
        'jenis_dokumen',
        'file_path',
        'uploaded_at',
    ];

    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class);
    }
}