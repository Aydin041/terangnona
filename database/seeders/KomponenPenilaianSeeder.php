<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Isi awal 14 komponen penilaian proposal (total bobot 100%).
 *
 * Nomor id TIDAK boleh diubah: kode lain mengacu ke nomor ini
 * (mis. id 7 = lampiran RAB, id 14 = lampiran Rencana Aksi).
 *
 * Aman dijalankan berulang: baris yang sudah ada diperbarui, yang belum ada dibuat.
 *
 * Jalankan: php artisan db:seed --class=KomponenPenilaianSeeder
 */
class KomponenPenilaianSeeder extends Seeder
{
    public function run(): void
    {
        $komponen = [
            ['id' => 1,  'nama' => 'Ringkasan',                                   'bobot' => 0,  'jumlah_kata_maksimal' => 300,  'kolom_target' => 'keduanya'],
            ['id' => 2,  'nama' => 'Dasar Hukum',                                 'bobot' => 5,  'jumlah_kata_maksimal' => 200,  'kolom_target' => 'keduanya'],
            ['id' => 3,  'nama' => 'Latar Belakang',                              'bobot' => 5,  'jumlah_kata_maksimal' => 200,  'kolom_target' => 'keduanya'],
            ['id' => 4,  'nama' => 'Tujuan',                                      'bobot' => 5,  'jumlah_kata_maksimal' => 150,  'kolom_target' => 'keduanya'],
            ['id' => 5,  'nama' => 'Keunggulan/Kebaruan',                         'bobot' => 5,  'jumlah_kata_maksimal' => 200,  'kolom_target' => 'keduanya'],
            ['id' => 6,  'nama' => 'Cara Kerja Inovasi',                          'bobot' => 10, 'jumlah_kata_maksimal' => 250,  'kolom_target' => 'keduanya'],
            ['id' => 7,  'nama' => 'Sumberdaya/Proyeksinya/RAB',                  'bobot' => 10, 'jumlah_kata_maksimal' => 250,  'kolom_target' => 'keduanya'],
            ['id' => 8,  'nama' => 'Desain Indegrasi/Integrasi',                  'bobot' => 10, 'jumlah_kata_maksimal' => 250,  'kolom_target' => 'keduanya'],
            ['id' => 9,  'nama' => 'Kolaborasi/Potensinya',                       'bobot' => 5,  'jumlah_kata_maksimal' => 200,  'kolom_target' => 'keduanya'],
            ['id' => 10, 'nama' => 'Difusi/Potensinya',                           'bobot' => 5,  'jumlah_kata_maksimal' => 150,  'kolom_target' => 'keduanya'],
            ['id' => 11, 'nama' => 'Replika/Potensinya',                          'bobot' => 10, 'jumlah_kata_maksimal' => 150,  'kolom_target' => 'keduanya'],
            ['id' => 12, 'nama' => 'Mekanisme/Rancangan Monitoring dan Evaluasi', 'bobot' => 10, 'jumlah_kata_maksimal' => 150,  'kolom_target' => 'keduanya'],
            ['id' => 13, 'nama' => 'Dampak Inovasi',                              'bobot' => 15, 'jumlah_kata_maksimal' => 300,  'kolom_target' => 'keduanya'],
            ['id' => 14, 'nama' => 'Rencana Aksi/Pengembangan',                   'bobot' => 5,  'jumlah_kata_maksimal' => null, 'kolom_target' => 'rancangan_inovasi'],
        ];

        $sekarang = now();

        foreach ($komponen as $baris) {
            $sudahAda = DB::table('komponen_penilaian')->where('id', $baris['id'])->exists();

            if ($sudahAda) {
                DB::table('komponen_penilaian')
                    ->where('id', $baris['id'])
                    ->update($baris + ['updated_at' => $sekarang]);
            } else {
                DB::table('komponen_penilaian')
                    ->insert($baris + ['created_at' => $sekarang, 'updated_at' => $sekarang]);
            }
        }

        $total = (float) DB::table('komponen_penilaian')->sum('bobot');

        if (abs($total - 100) > 0.001) {
            $this->command->warn("Perhatian: total bobot komponen = {$total}, seharusnya 100.");
        } else {
            $this->command->info('Komponen penilaian siap: ' . count($komponen) . ' komponen, total bobot 100.');
        }
    }
}