<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * 16 unit kerja untuk pilihan di form pengajuan.
 * Nomor id dikunci (tabel pengajuan mengacu ke nomor ini).
 *
 * Aman dijalankan berulang dan TIDAK menimpa data yang sudah ada:
 * baris yang belum ada dibuat, baris yang sudah ada tapi namanya berbeda
 * hanya diberi peringatan.
 *
 * Jalankan: php artisan db:seed --class=UnitKerjaSeeder
 */
class UnitKerjaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            1  => 'Sekretariat Dinas',
            2  => 'Bidang Pelatihan Kerja dan Produktivitas',
            3  => 'Bidang Penempatan Tenaga Kerja dan Transmigrasi',
            4  => 'Bidang Hubungan Industrial dan Jaminan Sosial',
            5  => 'Bidang Pengawasan Ketenagakerjaan',
            6  => 'Balai Latihan Kerja Industri - Cilacap',
            7  => 'Balai Latihan Kerja Pertanian - Klampok',
            8  => 'Balai Latihan Kerja Jasa dan Pariwisata - Semarang',
            9  => 'Balai Pengembangan Produktivitas',
            10 => 'Balai Keselamatan dan Kesehatan Kerja',
            11 => 'Satuan Pengawasan Ketenagakerjaan Wilayah Banyumas',
            12 => 'Satuan Pengawasan Ketenagakerjaan Wilayah Magelang',
            13 => 'Satuan Pengawasan Ketenagakerjaan Wilayah Surakarta',
            14 => 'Satuan Pengawasan Ketenagakerjaan Wilayah Pati',
            15 => 'Satuan Pengawasan Ketenagakerjaan Wilayah Pekalongan',
            16 => 'Satuan Pengawasan Ketenagakerjaan Wilayah Semarang',
        ];

        $dibuat = 0;
        $berbeda = 0;

        foreach ($data as $id => $nama) {
            $baris = DB::table('unit_kerja')->where('id', $id)->first();

            if ($baris === null) {
                DB::table('unit_kerja')->insert([
                    'id' => $id,
                    'nama' => $nama,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $dibuat++;
            } elseif ($baris->nama !== $nama) {
                $berbeda++;
                $this->command->warn("Unit kerja id {$id}: di database \"{$baris->nama}\" | di seeder \"{$nama}\" (tidak diubah).");
            }
        }

        $this->command->info("Unit kerja: {$dibuat} dibuat, {$berbeda} berbeda dari seeder (dari " . count($data) . ' data).');
    }
}