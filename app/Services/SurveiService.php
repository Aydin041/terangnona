<?php

namespace App\Services;

use App\Models\Peserta;
use App\Models\SurveiJawaban;

class SurveiService
{
    /**
     * Pilihan aspek yang perlu ditingkatkan (urutan dan redaksi sesuai Google Form).
     */
    public const ASPEK = [
        'sop' => 'Standard Operating Procedure (SOP)',
        'sarana' => 'Sarana/ Prasarana Kompetisi',
        'sistematika' => 'Sistematika Kompetisi',
        'akuntabilitas' => 'Akuntabilitas & Transparansi Penyelenggaraan',
        'penghargaan' => 'Penghargaan',
    ];

    /**
     * Status pengajuan yang sudah mendapat keputusan akhir dari Panitia.
     */
    public const STATUS_LAYAK = ['disetujui', 'ditolak'];

    /**
     * Peserta yang boleh mengisi survei: sedikitnya satu pengajuannya sudah disetujui atau ditolak.
     */
    public static function pesertaLayak()
    {
        return Peserta::query()->whereHas('pengajuan', fn ($q) => $q->whereIn('status', self::STATUS_LAYAK));
    }

    /**
     * Ringkasan hasil survei. Hanya memuat data gabungan dan tidak pernah memuat identitas.
     * Saran diurutkan abjad (bukan menurut waktu masuk) agar urutan pengisian tidak terbaca.
     */
    public static function ringkasan(): array
    {
        $jawaban = SurveiJawaban::query()->get(['nilai', 'aspek', 'saran']);
        $jumlah = $jawaban->count();

        $distribusi = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
        foreach ($jawaban as $baris) {
            if (isset($distribusi[$baris->nilai])) {
                $distribusi[$baris->nilai]++;
            }
        }

        $aspek = [];
        foreach (self::ASPEK as $kunci => $label) {
            $aspek[$label] = $jawaban->filter(fn ($baris) => in_array($kunci, $baris->aspek ?? [], true))->count();
        }

        $saran = $jawaban->pluck('saran')
            ->filter(fn ($teks) => filled($teks))
            ->sort(SORT_NATURAL | SORT_FLAG_CASE)
            ->values()
            ->all();

        return [
            'jumlah' => $jumlah,
            'rata' => $jumlah > 0 ? round($jawaban->avg('nilai'), 1) : null,
            'distribusi' => $distribusi,
            'aspek' => $aspek,
            'saran' => $saran,
        ];
    }
}