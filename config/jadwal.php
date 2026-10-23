<?php

/*
|--------------------------------------------------------------------------
| Jadwal Kompetisi TERANG NONA 2026
|--------------------------------------------------------------------------
| Sumber: jadwal pelaksanaan pada dokumen panduan resmi.
| Halaman depan membaca daftar ini dan menghitung sendiri status tiap tahap
| (belum dimulai / sedang berlangsung / sudah lewat) dari tanggal hari ini.
|
| Mengubah jadwal: ubah 'mulai' dan 'selesai' (format tahun-bulan-tanggal).
| 'label' dan 'ringkas' bersifat opsional; kalau dikosongkan, teks tanggal dibuat otomatis.
| Batas akhir 'pendaftaran' otomatis mengikuti Deadline Pengajuan di halaman
| Pengaturan Admin bila deadline itu diisi.
|
| Catatan: kalau server memakai "php artisan config:cache", jalankan
| "php artisan config:clear" setelah mengubah berkas ini.
*/

return [
    'zona_waktu' => 'Asia/Jakarta',

    'tahap' => [
        [
            'kunci' => 'sosialisasi',
            'nama' => 'Sosialisasi dan BIMTEK Kompetisi TERANG NONA 2026',
            'mulai' => '2026-08-31',
            'selesai' => '2026-08-31',
        ],
        [
            'kunci' => 'pendaftaran',
            'nama' => 'Pendaftaran dan Pelengkapan Bukti Dukung Rancangan/Pengembangan/Inovasi',
            'mulai' => '2026-08-31',
            'selesai' => '2026-10-31',
            'sorot' => 'Pendaftaran',
        ],
        [
            'kunci' => 'pencermatan',
            'nama' => 'Pencermatan dan Revisi Proposal Rancangan/Pengembangan/Inovasi',
            'mulai' => '2026-11-01',
            'selesai' => '2026-11-07',
        ],
        [
            'kunci' => 'penilaian',
            'nama' => 'Penilaian Proposal Rancangan/Pengembangan/Inovasi',
            'mulai' => '2026-11-09',
            'selesai' => '2026-11-13',
        ],
        [
            'kunci' => 'presentasi',
            'nama' => 'Presentasi Proposal Rancangan/Pengembangan/Inovasi',
            'mulai' => '2026-11-17',
            'selesai' => '2026-11-17',
            'sorot' => 'Presentasi proposal',
        ],
        [
            'kunci' => 'pengumuman',
            'nama' => 'Pengumuman Hasil Kompetisi TERANG NONA 2026',
            'mulai' => '2026-11-23',
            'selesai' => '2026-11-23',
            'sorot' => 'Pengumuman hasil',
        ],
        [
            'kunci' => 'penghargaan',
            'nama' => 'Penyerahan Penghargaan Kompetisi TERANG NONA 2026',
            'mulai' => '2026-11-29',
            'selesai' => '2026-11-30',
            'label' => '29/30 November 2026',
            'ringkas' => '29/30 Nov',
            'sorot' => 'Penyerahan penghargaan',
        ],
    ],
];