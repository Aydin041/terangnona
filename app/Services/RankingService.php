<?php

namespace App\Services;

use App\Models\KomponenPenilaian;
use App\Models\NilaiKomponenProposal;
use App\Models\Pengajuan;
use App\Models\SubmissionProposal;

class RankingService
{
    const MINIMAL_JURI_SUBMIT = 2;

    public function jumlahJuriSubmit(Pengajuan $pengajuan): int
    {
        return SubmissionProposal::where('pengajuan_id', $pengajuan->id)
            ->where('status', 'submitted')
            ->count();
    }

    public function hitungNilaiProposal(Pengajuan $pengajuan): ?float
    {
        $submissionSubmitted = SubmissionProposal::where('pengajuan_id', $pengajuan->id)
            ->where('status', 'submitted')
            ->pluck('id');

        if ($submissionSubmitted->count() < self::MINIMAL_JURI_SUBMIT) {
            return null; // belum cukup juri yang submit, nilai belum final
        }

        $komponenList = KomponenPenilaian::all()->filter(function ($komponen) use ($pengajuan) {
            if ($komponen->kolom_target === 'keduanya') {
                return true;
            }
            return $pengajuan->bentuk_inovasi !== 'eksisting';
        });

        $totalNilai = 0;

        foreach ($komponenList as $komponen) {
            $rataRata = NilaiKomponenProposal::whereIn('submission_id', $submissionSubmitted)
                ->where('komponen_id', $komponen->id)
                ->avg('nilai');

            $rataRata = $rataRata ?? 0;
            $totalNilai += ($rataRata * $komponen->bobot / 100);
        }

        // Eksisting otomatis dapat 100 utk komponen "Rencana Aksi/Pengembangan" (bobot 5%)
        if ($pengajuan->bentuk_inovasi === 'eksisting') {
            $totalNilai += (100 * 5 / 100); // = 5
        }

        return round($totalNilai, 2);
    }

    public function rankingPerKelompok(): array
    {
        $semuaPengajuan = Pengajuan::whereIn('status', ['disetujui'])->get();

        $hasil = [
            'eksisting' => [],
            'pengembangan_rancangan' => [],
        ];

        foreach ($semuaPengajuan as $pengajuan) {
            $nilai = $this->hitungNilaiProposal($pengajuan);
            if ($nilai === null) {
                continue; // skip yg belum cukup juri submit
            }

            $kelompok = $pengajuan->kelompok_penilaian;
            $hasil[$kelompok][] = [
                'pengajuan' => $pengajuan,
                'nilai_proposal' => $nilai,
            ];
        }

        foreach ($hasil as $kelompok => $daftar) {
            usort($daftar, function ($a, $b) {
                return $b['nilai_proposal'] <=> $a['nilai_proposal'];
            });
            $hasil[$kelompok] = $daftar;
        }

        return $hasil;
    }

    public function idPengajuanLolos5Besar(): array
    {
        $ranking = $this->rankingPerKelompok();
        $lolos = [];

        foreach ($ranking as $kelompok => $daftar) {
            $batas = min(5, count($daftar));
            for ($i = 0; $i < $batas; $i++) {
                $lolos[] = $daftar[$i]['pengajuan']->id;
            }
        }

        return $lolos;
    }
}