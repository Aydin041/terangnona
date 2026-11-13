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
        'nama_asli',
        'file_path',
        'uploaded_at',
    ];

    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class);
    }

    /**
     * Dokumen sekarang berupa tautan (kolom file_path berisi alamat http/https).
     * Data lama masih berupa berkas yang diunggah (file_path berisi jalur penyimpanan),
     * jadi keduanya tetap ditampilkan dengan benar selama masa peralihan.
     */
    public function getAdalahTautanAttribute(): bool
    {
        return preg_match('#^https?://#i', (string) $this->file_path) === 1;
    }

    public function getTautanAttribute(): ?string
    {
        if (blank($this->file_path)) {
            return null;
        }

        return $this->adalah_tautan
            ? $this->file_path
            : asset('storage/' . $this->file_path);
    }

    public function getLabelAttribute(): string
    {
        if ($this->adalah_tautan) {
            return (string) $this->file_path;
        }

        return $this->nama_asli ?: basename((string) $this->file_path);
    }

    /**
     * Nama jenis dokumen yang mudah dibaca (untuk ditampilkan ke pengguna).
     */
    public function getNamaJenisAttribute(): string
    {
        $daftar = [
            'surat_identitas' => 'Surat Pernyataan Identitas Inovator',
            'surat_implementasi' => 'Surat Pernyataan Implementasi Inovasi',
            'surat_komitmen' => 'Surat Pernyataan Komitmen Implementasi Inovasi',
            'video_link' => 'Video Dampak Inovasi',
            'lampiran_rab' => 'Dokumen RAB',
            'lampiran_rencana_aksi' => 'Lampiran Rencana Aksi/Pengembangan',
        ];

        return $daftar[$this->jenis_dokumen]
            ?? ucwords(str_replace('_', ' ', (string) $this->jenis_dokumen));
    }
}