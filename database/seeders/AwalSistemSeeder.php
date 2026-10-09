<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Mengisi semua data awal yang dibutuhkan sistem pada instalasi baru.
 *
 * Urutan pemasangan di komputer/server baru:
 *   php artisan migrate
 *   php artisan db:seed --class=AwalSistemSeeder
 */
class AwalSistemSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            KomponenPenilaianSeeder::class,
            UnitKerjaSeeder::class,
            KategoriSeeder::class,
            AdminSeeder::class,
        ]);
    }
}