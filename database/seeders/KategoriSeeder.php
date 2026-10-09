<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * 6 kategori inovasi.
 * Nomor id dikunci (tabel pengajuan mengacu ke nomor ini).
 *
 * Aman dijalankan berulang dan TIDAK menimpa data yang sudah ada:
 * baris yang belum ada dibuat, baris yang sudah ada tapi namanya berbeda
 * hanya diberi peringatan.
 *
 * Jalankan: php artisan db:seed --class=KategoriSeeder
 */
class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            1 => 'Pelatihan Kerja dan Produktivitas',
            2 => 'Penempatan Tenaga Kerja dan Transmigrasi',
            3 => 'Pengawasan dan Perlindungan Tenaga Kerja',
            4 => 'Hubungan Industrial dan Jaminan Sosial',
            5 => 'Dukungan Pemerintahan dan Reformasi Birokrasi Nakertrans',
            6 => 'Pengelolaan Data, Informasi dan Pelayanan Publik',
        ];

        $dibuat = 0;
        $berbeda = 0;

        foreach ($data as $id => $nama) {
            $baris = DB::table('kategori')->where('id', $id)->first();

            if ($baris === null) {
                DB::table('kategori')->insert([
                    'id' => $id,
                    'nama' => $nama,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $dibuat++;
            } elseif ($baris->nama !== $nama) {
                $berbeda++;
                $this->command->warn("Kategori id {$id}: di database \"{$baris->nama}\" | di seeder \"{$nama}\" (tidak diubah).");
            }
        }

        $this->command->info("Kategori: {$dibuat} dibuat, {$berbeda} berbeda dari seeder (dari " . count($data) . ' data).');
    }
}