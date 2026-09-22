<?php

namespace App\Services;

use App\Models\Pengajuan;
use App\Models\SubmissionPresentasi;
use App\Models\SubmissionProposal;

class NilaiReportService
{
    /**
     * Ambil semua pengajuan yang sudah pernah dinilai (punya minimal 1 submission
     * proposal atau presentasi), lengkap dengan rincian nilai per Juri per
     * komponen/aspek, plus kapan submission itu terakhir disubmit.
     * Read-only — tidak dipakai untuk ubah/hapus apa pun.
     */
    public function ambilData(): array
    {
        $idPengajuanDinilai = SubmissionProposal::pluck('pengajuan_id')
            ->merge(SubmissionPresentasi::pluck('pengajuan_id'))
            ->unique();

        $pengajuanList = Pengajuan::with('kategori')
            ->whereIn('id', $idPengajuanDinilai)
            ->orderBy('nama_inovasi')
            ->get();

        $hasil = [];
        foreach ($pengajuanList as $pengajuan) {
            $submisiProposal = SubmissionProposal::with(['juri', 'nilaiKomponen.komponen'])
                ->where('pengajuan_id', $pengajuan->id)
                ->get();

            $submisiPresentasi = SubmissionPresentasi::with(['juri', 'nilaiAspek'])
                ->where('pengajuan_id', $pengajuan->id)
                ->get();

            $hasil[] = [
                'pengajuan' => $pengajuan,
                'proposal' => $submisiProposal,
                'presentasi' => $submisiPresentasi,
            ];
        }

        return $hasil;
    }
}