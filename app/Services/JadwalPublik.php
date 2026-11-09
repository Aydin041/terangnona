<?php

namespace App\Services;

use App\Models\Pengaturan;
use App\Models\TahapJadwal;
use Illuminate\Support\Carbon;

class JadwalPublik
{
    /**
     * Data jadwal untuk halaman-halaman publik (Beranda, Tentang, Jadwal, Download).
     * Status tiap tahap dihitung dari tanggal hari ini.
     */
    public static function data(): array
    {
        $tz = config('jadwal.zona_waktu', 'Asia/Jakarta');
        $sekarang = Carbon::now($tz);

        try {
            $deadline = Pengaturan::ambil()->deadline_pengajuan;
        } catch (\Throwable $e) {
            // Database belum siap: halaman tetap tampil memakai jadwal dari config/jadwal.php.
            $deadline = null;
        }

        // Singkatan bulan Agustus dari pustaka tanggal adalah "Agt"; di sini dibuat "Agu" sesuai desain.
        $f = fn ($c, $pola) => str_replace('Agt', 'Agu', $c->copy()->locale('id')->translatedFormat($pola));

        $tahapList = collect(TahapJadwal::semua())->map(function ($t) use ($tz, $sekarang, $deadline, $f) {
            $mulai = Carbon::parse($t['mulai'], $tz)->startOfDay();
            $selesai = Carbon::parse($t['selesai'], $tz)->endOfDay();

            // Batas akhir pendaftaran mengikuti Deadline Pengajuan di Pengaturan Admin (kalau diisi).
            if ($t['kunci'] === 'pendaftaran' && $deadline) {
                $selesai = Carbon::parse($deadline)->setTimezone($tz);
            }

            $t['mulai_c'] = $mulai;
            $t['selesai_c'] = $selesai;
            $t['status'] = $sekarang->lt($mulai) ? 'belum' : ($sekarang->gt($selesai) ? 'lewat' : 'berlangsung');

            $sama = $mulai->isSameDay($selesai);
            $t['teks'] = $t['label'] ?? ($sama ? $f($mulai, 'j F Y') : $f($mulai, 'j F Y') . ' s/d ' . $f($selesai, 'j F Y'));
            $t['teks_ringkas'] = $t['ringkas'] ?? ($sama
                ? $f($mulai, 'j M')
                : ($mulai->isSameMonth($selesai)
                    ? $f($mulai, 'j') . ' – ' . $f($selesai, 'j M')
                    : $f($mulai, 'j M') . ' – ' . $f($selesai, 'j M')));

            return $t;
        });

        $daftar = $tahapList->firstWhere('kunci', 'pendaftaran');

        // Foto latar hero: letakkan di public/images dengan nama hero-latar (webp, jpg, jpeg, atau png).
        $fotoHero = collect(['webp', 'jpg', 'jpeg', 'png'])
            ->map(fn ($ekstensi) => 'images/hero-latar.' . $ekstensi)
            ->first(fn ($jalur) => file_exists(public_path($jalur)));

        return [
            'tahapList' => $tahapList,
            'tahunKompetisi' => $tahapList->first()['mulai_c']->year,
            'daftar' => $daftar,
            'statusDaftar' => $daftar['status'],
            'sorotan' => $tahapList->filter(fn ($t) => ! empty($t['sorot']))->values(),
            'fotoHero' => $fotoHero,
            'labelStatus' => [
                'belum' => 'Belum dimulai',
                'berlangsung' => 'Sedang berlangsung',
                'lewat' => 'Sudah lewat',
            ],
        ];
    }
}