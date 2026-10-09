<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Membuat akun Admin pertama pada instalasi baru.
 *
 * Password TIDAK ditulis di kode: diketik saat seeder dijalankan dan
 * disimpan dalam bentuk terenkripsi. Kalau sudah ada akun Admin,
 * seeder ini dilewati dan tidak mengubah apa pun.
 *
 * Jalankan: php artisan db:seed --class=AdminSeeder
 */
class AdminSeeder extends Seeder
{
    public function run(): void
    {
        if (DB::table('admin')->exists()) {
            $this->command->info('Akun Admin sudah ada, dilewati.');
            return;
        }

        $this->command->info('Belum ada akun Admin. Buat akun Admin pertama.');

        $nama = trim((string) $this->command->ask('Nama Admin', 'Admin TERANG NONA'));
        $email = trim((string) $this->command->ask('Email Admin'));
        $password = (string) $this->command->secret('Password Admin (minimal 10 karakter)');
        $ulang = (string) $this->command->secret('Ulangi password');

        if ($nama === '' || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->command->error('Nama atau email tidak valid. Akun Admin tidak dibuat. Jalankan seeder ini lagi.');
            return;
        }

        if (strlen($password) < 10) {
            $this->command->error('Password minimal 10 karakter. Akun Admin tidak dibuat. Jalankan seeder ini lagi.');
            return;
        }

        if ($password !== $ulang) {
            $this->command->error('Kedua password tidak sama. Akun Admin tidak dibuat. Jalankan seeder ini lagi.');
            return;
        }

        DB::table('admin')->insert([
            'nama' => $nama,
            'email' => $email,
            'password_hash' => Hash::make($password),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->command->info("Akun Admin dibuat: {$email}");
    }
}