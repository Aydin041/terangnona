<?php

namespace App\Services;

use App\Models\KomponenPenilaian;
use App\Models\NilaiAspekPresentasi;
use App\Models\NilaiKomponenProposal;
use App\Models\Pengajuan;
use App\Models\SubmissionPresentasi;
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
            return null;
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

        if ($pengajuan->bentuk_inovasi === 'eksisting') {
            $totalNilai += (100 * 5 / 100);
        }

        return round($totalNilai, 2);
    }

    public function hitungNilaiPresentasi(Pengajuan $pengajuan): ?float
    {
        $submissionSubmitted = SubmissionPresentasi::where('pengajuan_id', $pengajuan->id)
            ->where('status', 'submitted')
            ->pluck('id');

        if ($submissionSubmitted->count() < self::MINIMAL_JURI_SUBMIT) {
            return null;
        }

        $aspekList = ['teknik_penyajian', 'substansi_materi', 'komitmen_pimpinan'];
        $totalNilai = 0;

        foreach ($aspekList as $aspek) {
            $rataRata = NilaiAspekPresentasi::whereIn('submission_id', $submissionSubmitted)
                ->where('aspek', $aspek)
                ->avg('nilai');

            $rataRata = $rataRata ?? 0;
            $totalNilai += $rataRata;
        }

        return round($totalNilai / count($aspekList), 2);
    }

    public function hitungNilaiAkhir(Pengajuan $pengajuan): ?float
    {
        $nilaiProposal = $this->hitungNilaiProposal($pengajuan);
        $nilaiPresentasi = $this->hitungNilaiPresentasi($pengajuan);

        if ($nilaiProposal === null || $nilaiPresentasi === null) {
            return null;
        }

        return round(($nilaiProposal * 0.75) + ($nilaiPresentasi * 0.25), 2);
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
                continue;
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

    public function rankingAkhirPerKelompok(): array
    {
        $idLolos5Besar = $this->idPengajuanLolos5Besar();
        $pengajuanLolos = Pengajuan::whereIn('id', $idLolos5Besar)->get();

        $hasil = [
            'eksisting' => [],
            'pengembangan_rancangan' => [],
        ];

        foreach ($pengajuanLolos as $pengajuan) {
            $nilaiAkhir = $this->hitungNilaiAkhir($pengajuan);
            if ($nilaiAkhir === null) {
                continue; // belum cukup juri nilai presentasinya
            }

            $kelompok = $pengajuan->kelompok_penilaian;
            $hasil[$kelompok][] = [
                'pengajuan' => $pengajuan,
                'nilai_proposal' => $this->hitungNilaiProposal($pengajuan),
                'nilai_presentasi' => $this->hitungNilaiPresentasi($pengajuan),
                'nilai_akhir' => $nilaiAkhir,
            ];
        }

        foreach ($hasil as $kelompok => $daftar) {
            usort($daftar, function ($a, $b) {
                return $b['nilai_akhir'] <=> $a['nilai_akhir'];
            });
            $hasil[$kelompok] = $daftar;
        }

        return $hasil;
    }

    public function idPengajuan3Besar(): array
    {
        $ranking = $this->rankingAkhirPerKelompok();
        $juara = [];

        foreach ($ranking as $kelompok => $daftar) {
            $batas = min(3, count($daftar));
            for ($i = 0; $i < $batas; $i++) {
                $juara[] = $daftar[$i]['pengajuan']->id;
            }
        }

        return $juara;
    }
}