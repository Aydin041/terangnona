<?php

namespace App\Services;

use App\Models\KomponenPenilaian;
use App\Models\NilaiAspekPresentasi;
use App\Models\NilaiKomponenProposal;
use App\Models\Pengaturan;
use App\Models\Pengajuan;
use App\Models\SubmissionPresentasi;
use App\Models\SubmissionProposal;

class RankingService
{
    private ?int $minimalJuriCache = null;

    private function minimalJuri(): int
    {
        if ($this->minimalJuriCache === null) {
            $this->minimalJuriCache = Pengaturan::minimalJuriSubmit();
        }

        return $this->minimalJuriCache;
    }

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

        if ($submissionSubmitted->count() < $this->minimalJuri()) {
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
            // Komponen yang tidak berlaku untuk Eksisting (mis. Rencana Aksi) otomatis
            // dapat nilai 100, tetap ditimbang sesuai bobotnya di database.
            $bobotTidakBerlaku = (float) KomponenPenilaian::where('kolom_target', '!=', 'keduanya')->sum('bobot');
            $totalNilai += (100 * $bobotTidakBerlaku / 100);
        }

        return round($totalNilai, 2);
    }

    public function hitungNilaiPresentasi(Pengajuan $pengajuan): ?float
    {
        $submissionSubmitted = SubmissionPresentasi::where('pengajuan_id', $pengajuan->id)
            ->where('status', 'submitted')
            ->pluck('id');

        if ($submissionSubmitted->count() < $this->minimalJuri()) {
            return null;
        }

        // Bobot resmi per aspek (total 100%) — dulu dianggap sama rata, sekarang ditimbang.
        $aspekBobot = [
            'teknik_penyajian' => 20,
            'substansi_materi' => 70,
            'komitmen_pimpinan' => 10,
        ];
        $totalNilai = 0;

        foreach ($aspekBobot as $aspek => $bobot) {
            $rataRata = NilaiAspekPresentasi::whereIn('submission_id', $submissionSubmitted)
                ->where('aspek', $aspek)
                ->avg('nilai');

            $rataRata = $rataRata ?? 0;
            $totalNilai += ($bobot / 100) * $rataRata;
        }

        return round($totalNilai, 2);
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

    /**
     * Ambil top-N dari masing-masing kelompok (daftar sudah terurut desc).
     * Kalau salah satu kelompok kurang dari kuota, sisanya dipinjam dari
     * peringkat berikutnya di kelompok lain (Opsi 1: kuota per kelompok
     * tetap jadi acuan, cross-kelompok cuma cadangan kalau ada kekurangan).
     */
    private function ambilDenganPinjamAntarKelompok(array $daftarA, array $daftarB, int $kuota): array
    {
        $ambil = array_merge(
            array_slice($daftarA, 0, $kuota),
            array_slice($daftarB, 0, $kuota)
        );

        $kekuranganA = $kuota - min($kuota, count($daftarA));
        $kekuranganB = $kuota - min($kuota, count($daftarB));

        if ($kekuranganA > 0) {
            $ambil = array_merge($ambil, array_slice($daftarB, $kuota, $kekuranganA));
        }
        if ($kekuranganB > 0) {
            $ambil = array_merge($ambil, array_slice($daftarA, $kuota, $kekuranganB));
        }

        return $ambil;
    }

    public function idPengajuanLolos5Besar(): array
    {
        $ranking = $this->rankingPerKelompok();

        $gabungan = $this->ambilDenganPinjamAntarKelompok(
            $ranking['eksisting'],
            $ranking['pengembangan_rancangan'],
            5
        );

        return array_map(fn ($item) => $item['pengajuan']->id, $gabungan);
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

        $gabungan = $this->ambilDenganPinjamAntarKelompok(
            $ranking['eksisting'],
            $ranking['pengembangan_rancangan'],
            3
        );

        return array_map(fn ($item) => $item['pengajuan']->id, $gabungan);
    }
}