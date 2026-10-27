<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PermintaanBukaKunci extends Model
{
    protected static function booted(): void
    {
        static::creating(function (self $model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    protected $table = 'permintaan_buka_kunci';

    protected $fillable = [
        'juri_id',
        'pengajuan_id',
        'tahap',
        'komponen_id',
        'aspek',
        'alasan',
        'status_persetujuan',
        'admin_id',
    ];

    public function juri()
    {
        return $this->belongsTo(Juri::class);
    }

    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class);
    }

    public function komponen()
    {
        return $this->belongsTo(KomponenPenilaian::class, 'komponen_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}