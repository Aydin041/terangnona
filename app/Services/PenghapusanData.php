<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Penghapusan permanen pengajuan dan akun beserta seluruh data turunannya.
 *
 * Semua penghapusan basis data berjalan dalam satu transaksi: kalau satu langkah gagal,
 * tidak ada data yang berubah. Berkas fisik di storage baru dihapus SETELAH transaksi berhasil.
 */
class PenghapusanData
{
    // ---------------------------------------------------------------- ringkasan (untuk halaman konfirmasi)

    public function ringkasanPengajuan(int $id): array
    {
        $subProposal = DB::table('submission_proposal')->where('pengajuan_id', $id)->pluck('id');
        $subPresentasi = DB::table('submission_presentasi')->where('pengajuan_id', $id)->pluck('id');

        return array_filter([
            'Anggota kelompok' => DB::table('anggota_kelompok')->where('pengajuan_id', $id)->count(),
            'Dokumen / tautan' => DB::table('dokumen')->where('pengajuan_id', $id)->count(),
            'Isian proposal' => DB::table('isian_proposal')->where('pengajuan_id', $id)->count(),
            'Penilaian proposal dari juri' => DB::table('submission_proposal')->where('pengajuan_id', $id)->count(),
            'Penilaian presentasi dari juri' => DB::table('submission_presentasi')->where('pengajuan_id', $id)->count(),
            'Riwayat status pemeriksaan' => DB::table('riwayat_status')->where('pengajuan_id', $id)->count(),
            'Permintaan buka kunci' => DB::table('permintaan_buka_kunci')->where('pengajuan_id', $id)->count(),
        ]);
    }

    public function ringkasanPeserta(int $id): array
    {
        $ids = DB::table('pengajuan')->where('peserta_id', $id)->pluck('id');
        $ringkasan = ['Pengajuan' => $ids->count()];

        foreach ([
            'Penilaian proposal dari juri' => 'submission_proposal',
            'Penilaian presentasi dari juri' => 'submission_presentasi',
            'Dokumen / tautan' => 'dokumen',
            'Riwayat status pemeriksaan' => 'riwayat_status',
        ] as $label => $tabel) {
            $ringkasan[$label] = DB::table($tabel)->whereIn('pengajuan_id', $ids)->count();
        }

        return array_filter($ringkasan);
    }

    public function ringkasanJuri(int $id): array
    {
        return array_filter([
            'Penilaian proposal (termasuk yang sudah disubmit)' => DB::table('submission_proposal')->where('juri_id', $id)->count(),
            'Penilaian presentasi (termasuk yang sudah disubmit)' => DB::table('submission_presentasi')->where('juri_id', $id)->count(),
            'Permintaan buka kunci' => DB::table('permintaan_buka_kunci')->where('juri_id', $id)->count(),
        ]);
    }

    public function ringkasanPanitia(int $id): array
    {
        return array_filter([
            'Riwayat pemeriksaan yang namanya akan dikosongkan (catatan tetap ada)' => DB::table('riwayat_status')->where('panitia_id', $id)->count(),
        ]);
    }

    // ---------------------------------------------------------------- eksekusi

    public function hapusPengajuan(int $id): void
    {
        $berkas = DB::transaction(fn () => $this->bersihkanPengajuan($id));
        $this->hapusBerkas($berkas);
    }

    public function hapusPeserta(int $id): void
    {
        $berkas = DB::transaction(function () use ($id) {
            $berkas = [];
            foreach (DB::table('pengajuan')->where('peserta_id', $id)->pluck('id') as $pengajuanId) {
                $berkas = array_merge($berkas, $this->bersihkanPengajuan($pengajuanId));
            }

            // Tabel survei_jawaban sengaja tidak disentuh: jawaban anonim dan tidak terhubung ke peserta.
            DB::table('survei_partisipasi')->where('peserta_id', $id)->delete();
            DB::table('peserta')->where('id', $id)->delete();

            return $berkas;
        });

        $this->hapusBerkas($berkas);
    }

    public function hapusJuri(int $id): void
    {
        DB::transaction(function () use ($id) {
            $this->hapusSubmissionJuri('submission_proposal', 'nilai_komponen_proposal', $id);
            $this->hapusSubmissionJuri('submission_presentasi', 'nilai_aspek_presentasi', $id);
            DB::table('permintaan_buka_kunci')->where('juri_id', $id)->delete();
            DB::table('juri')->where('id', $id)->delete();
        });
    }

    public function hapusPanitia(int $id): void
    {
        DB::transaction(function () use ($id) {
            // Riwayat status milik pengajuan lain tidak boleh hilang, jadi hanya nama petugasnya yang dikosongkan.
            DB::table('riwayat_status')->where('panitia_id', $id)->update(['panitia_id' => null]);
            DB::table('panitia')->where('id', $id)->delete();
        });
    }

    // ---------------------------------------------------------------- internal

    private function bersihkanPengajuan(int $id): array
    {
        $berkas = DB::table('dokumen')->where('pengajuan_id', $id)->pluck('file_path')->all();

        $this->hapusSubmissionPengajuan('submission_proposal', 'nilai_komponen_proposal', $id);
        $this->hapusSubmissionPengajuan('submission_presentasi', 'nilai_aspek_presentasi', $id);

        DB::table('permintaan_buka_kunci')->where('pengajuan_id', $id)->delete();
        DB::table('riwayat_status')->where('pengajuan_id', $id)->delete();

        $isianIds = DB::table('isian_proposal')->where('pengajuan_id', $id)->pluck('id');
        DB::table('isian_proposal_link')->whereIn('isian_proposal_id', $isianIds)->delete();
        DB::table('isian_proposal')->where('pengajuan_id', $id)->delete();

        DB::table('anggota_kelompok')->where('pengajuan_id', $id)->delete();
        DB::table('dokumen')->where('pengajuan_id', $id)->delete();
        DB::table('pengajuan')->where('id', $id)->delete();

        return $berkas;
    }

    private function hapusSubmissionPengajuan(string $tabelSubmission, string $tabelNilai, int $pengajuanId): void
    {
        $ids = DB::table($tabelSubmission)->where('pengajuan_id', $pengajuanId)->pluck('id');
        DB::table($tabelNilai)->whereIn('submission_id', $ids)->delete();
        DB::table($tabelSubmission)->where('pengajuan_id', $pengajuanId)->delete();
    }

    private function hapusSubmissionJuri(string $tabelSubmission, string $tabelNilai, int $juriId): void
    {
        $ids = DB::table($tabelSubmission)->where('juri_id', $juriId)->pluck('id');
        DB::table($tabelNilai)->whereIn('submission_id', $ids)->delete();
        DB::table($tabelSubmission)->where('juri_id', $juriId)->delete();
    }

    /** Hapus berkas unggahan lama. Dokumen berupa tautan (http/https) tidak punya berkas fisik. */
    private function hapusBerkas(array $daftarPath): void
    {
        foreach ($daftarPath as $path) {
            $path = (string) $path;
            if ($path === '' || preg_match('#^https?://#i', $path) || str_contains($path, '..')) {
                continue;
            }
            try {
                Storage::disk('public')->delete($path);
            } catch (\Throwable $e) {
                report($e); // data sudah terhapus; berkas yatim tidak boleh menggagalkan proses
            }
        }
    }
}