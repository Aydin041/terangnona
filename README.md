# TERANG NONA 2026

Sistem informasi **Kompetisi Inovasi TERANG NONA** (Tenaga Kerja dan Transmigrasi Innovation Awards) 2026
milik Dinas Tenaga Kerja dan Transmigrasi Provinsi Jawa Tengah. Aplikasi ini mengelola pengajuan inovasi,
penilaian proposal dan presentasi oleh Juri, peringkat, serta laporan nilai.

## Teknologi

| Bagian | Yang dipakai |
| --- | --- |
| Bahasa pemrograman | PHP 8.5 |
| Framework | Laravel 12 |
| Database | MySQL 8 |
| Tampilan | Blade, Tailwind CSS (sudah dikompilasi di `public/css/app.css`), JavaScript biasa |
| Ekspor Excel | PhpSpreadsheet |
| Captcha | mews/captcha |

Tidak ada langkah `npm` yang diperlukan untuk menjalankan aplikasi.

## Peran pengguna

Peserta, Juri, Panitia, Admin, dan Pimpinan. Masing-masing memiliki halaman login sendiri.

## Kebutuhan server

- PHP 8.2 atau lebih baru (dikembangkan dan diuji pada PHP 8.5)
- Ekstensi PHP: `curl`, `fileinfo`, `gd`, `intl`, `mbstring`, `mysqli`, `openssl`, `pdo_mysql`, `zip`, `xml`
- MySQL 8 (atau MariaDB yang kompatibel)
- Composer 2
- Document root web server diarahkan ke folder `public`

## Cara pasang

```bash
git clone https://github.com/Aydin041/terangnona.git
cd terangnona

composer install --no-dev --optimize-autoloader

cp .env.example .env
php artisan key:generate
```

Buka file `.env`, lalu isi `APP_URL` dan data database (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).
Setelah itu:

```bash
php artisan migrate
php artisan db:seed --class=AwalSistemSeeder
```

Perintah `db:seed` akan menanyakan nama, email, dan password untuk akun **Admin** pertama
(password minimal 10 karakter). Tidak ada akun bawaan.

Pastikan folder `storage` dan `bootstrap/cache` dapat ditulis oleh web server.

## Catatan

- File `.env` tidak ikut tersimpan di repositori dan harus dibuat sendiri di server.
- Pada lingkungan produksi pastikan `APP_ENV=production` dan `APP_DEBUG=false`.
- Gunakan `php artisan config:cache` dan `php artisan view:cache` untuk mempercepat aplikasi.
  Jangan gunakan `php artisan route:cache`, karena rute halaman depan memakai closure.