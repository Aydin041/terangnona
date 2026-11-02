<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahapJadwal extends Model
{
    protected $table = 'tahap_jadwal';

    protected $fillable = ['kunci', 'nama', 'mulai', 'selesai', 'sorot', 'urutan'];

    protected $casts = [
        'mulai' => 'date',
        'selesai' => 'date',
    ];

    /**
     * Daftar tahap untuk halaman depan, dalam bentuk larik yang sama dengan config/jadwal.php.
     * Kalau tabelnya belum ada atau masih kosong, dipakai jadwal bawaan dari config/jadwal.php.
     */
    public static function semua(): array
    {
        $baris = static::urut();

        if ($baris->isEmpty()) {
            return config('jadwal.tahap');
        }

        $tahun = (int) $baris->first()->mulai->format('Y');

        return $baris->map(function (self $b) use ($tahun) {
            [$ringkas, $label] = self::teksDuaHari($b);

            return [
                'kunci' => $b->kunci,
                'nama' => str_replace('{tahun}', (string) $tahun, $b->nama),
                'mulai' => $b->mulai->format('Y-m-d'),
                'selesai' => $b->selesai->format('Y-m-d'),
                'sorot' => filled($b->sorot) ? $b->sorot : null,
                'ringkas' => $ringkas,
                'label' => $label,
            ];
        })->all();
    }

    /**
     * Tahun kompetisi = tahun tanggal mulai tahap pertama.
     */
    public static function tahun(): int
    {
        $pertama = static::urut()->first();

        return $pertama ? (int) $pertama->mulai->format('Y') : (int) config('jadwal.tahun');
    }

    /**
     * Semua tahap berurutan. Kalau tabel belum dibuat (migrasi belum dijalankan),
     * hasilnya kosong supaya halaman depan tetap tampil dengan jadwal bawaan.
     */
    public static function urut()
    {
        try {
            return static::orderBy('urutan')->orderBy('id')->get();
        } catch (\Throwable $e) {
            return collect();
        }
    }

    /**
     * Tahap yang hanya dua hari berurutan pada bulan yang sama ditulis "29/30".
     * Hasil: [teks ringkas, teks panjang], atau [null, null] untuk tahap lain.
     */
    private static function teksDuaHari(self $b): array
    {
        $duaHariBerurutan = $b->mulai->copy()->addDay()->isSameDay($b->selesai)
            && $b->mulai->month === $b->selesai->month;

        if (! $duaHariBerurutan) {
            return [null, null];
        }

        $hari = $b->mulai->day . '/' . $b->selesai->day;
        $bulanPendek = str_replace('Agt', 'Agu', $b->mulai->copy()->locale('id')->translatedFormat('M'));
        $bulanPanjang = $b->mulai->copy()->locale('id')->translatedFormat('F');

        return [
            $hari . ' ' . $bulanPendek,
            $hari . ' ' . $bulanPanjang . ' ' . $b->mulai->year,
        ];
    }
}