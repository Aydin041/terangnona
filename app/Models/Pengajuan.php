<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pengajuan extends Model
{
    protected $table = 'pengajuan';

    protected static function booted(): void
    {
        static::creating(function (Pengajuan $pengajuan) {
            if (empty($pengajuan->uuid)) {
                $pengajuan->uuid = (string) Str::uuid();
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    protected $fillable = [
        'peserta_id',
        'kategori_id',
        'unit_kerja_id',
        'nama_inovasi',
        'akronim',
        'bentuk_inovasi',
        'jenis_inovasi',
        'nama_narahubung',
        'kontak_narahubung',
        'email_narahubung',
        'tahun_implementasi',
        'deskripsi',
        'status',
        'link_presentasi',
    ];

    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class);
    }

    public function anggotaKelompok()
    {
        return $this->hasMany(AnggotaKelompok::class);
    }

    public function dokumen()
    {
        return $this->hasMany(Dokumen::class);
    }

    public function isianProposal()
    {
        return $this->hasMany(IsianProposal::class);
    }

    public function submissionProposal()
    {
        return $this->hasMany(SubmissionProposal::class);
    }

    public function submissionPresentasi()
    {
        return $this->hasMany(SubmissionPresentasi::class);
    }

    public function riwayatStatus()
    {
        return $this->hasMany(RiwayatStatus::class);
    }

    public function getKelompokPenilaianAttribute()
    {
        return $this->bentuk_inovasi === 'eksisting' ? 'eksisting' : 'pengembangan_rancangan';
    }
}