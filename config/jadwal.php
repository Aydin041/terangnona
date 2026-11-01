<?php

/*
|--------------------------------------------------------------------------
| Jadwal Kompetisi TERANG NONA
|--------------------------------------------------------------------------
| Sumber: jadwal pelaksanaan pada dokumen panduan resmi.
| Halaman depan membaca daftar ini dan menghitung sendiri status tiap tahap
| (belum dimulai / sedang berlangsung / sudah lewat) dari tanggal hari ini.
|
| Mengubah jadwal: ubah 'mulai' dan 'selesai' (format tahun-bulan-tanggal).
| Tahun kompetisi (di judul, teks halaman depan, dan nama tahap) otomatis mengikuti
| tahun 'mulai' pada tahap pertama; tulis {tahun} pada nama atau label untuk memakainya.
| 'label' dan 'ringkas' bersifat opsional; kalau dikosongkan, teks tanggal dibuat otomatis.
| Batas akhir 'pendaftaran' otomatis mengikuti Deadline Pengajuan di halaman
| Pengaturan Admin bila deadline itu diisi.
|
| 'sorot' = tahap yang ditampilkan sebagai kartu di bagian atas halaman depan (isinya
| adalah teks di bawah tanggal). Hapus baris 'sorot' kalau tahap tidak perlu ditampilkan di kartu.
|
| Catatan: kalau server memakai "php artisan config:cache", jalankan
| "php artisan config:clear" setelah mengubah berkas ini.
*/

$tahap = [
    [
        'kunci' => 'sosialisasi',
        'nama' => 'Sosialisasi dan BIMTEK Kompetisi TERANG NONA {tahun}',
        'mulai' => '2026-08-31',
        'selesai' => '2026-08-31',
    ],
    [
        'kunci' => 'pendaftaran',
        'nama' => 'Pendaftaran dan Pelengkapan Bukti Dukung Rancangan/Pengembangan/Inovasi',
        'mulai' => '2026-08-31',
        'selesai' => '2026-10-31',
        'sorot' => 'Pendaftaran & Bukti Dukung',
    ],
    [
        'kunci' => 'pencermatan',
        'nama' => 'Pencermatan dan Revisi Proposal Rancangan/Pengembangan/Inovasi',
        'mulai' => '2026-11-01',
        'selesai' => '2026-11-07',
        'sorot' => 'Pencermatan & Revisi Proposal',
    ],
    [
        'kunci' => 'penilaian',
        'nama' => 'Penilaian Proposal Rancangan/Pengembangan/Inovasi',
        'mulai' => '2026-11-09',
        'selesai' => '2026-11-13',
        'sorot' => 'Penilaian Proposal',
    ],
    [
        'kunci' => 'presentasi',
        'nama' => 'Presentasi Proposal Rancangan/Pengembangan/Inovasi',
        'mulai' => '2026-11-17',
        'selesai' => '2026-11-17',
        'sorot' => 'Presentasi Proposal',
    ],
    [
        'kunci' => 'pengumuman',
        'nama' => 'Pengumuman Hasil Kompetisi TERANG NONA {tahun}',
        'mulai' => '2026-11-23',
        'selesai' => '2026-11-23',
        'sorot' => 'Pengumuman Hasil',
    ],
    [
        'kunci' => 'penghargaan',
        'nama' => 'Penyerahan Penghargaan Kompetisi TERANG NONA {tahun}',
        'mulai' => '2026-11-29',
        'selesai' => '2026-11-30',
        'label' => '29/30 November {tahun}',
        'ringkas' => '29/30 Nov',
        'sorot' => 'Penyerahan Penghargaan',
    ],
];

// Tahun penyelenggaraan diambil dari tanggal mulai tahap pertama, jadi cukup mengubah jadwal.
// Penanda {tahun} pada nama dan label tahap diganti dengan tahun itu.
$tahun = (int) substr($tahap[0]['mulai'], 0, 4);

foreach ($tahap as &$butir) {
    $butir['nama'] = str_replace('{tahun}', (string) $tahun, $butir['nama']);

    if (isset($butir['label'])) {
        $butir['label'] = str_replace('{tahun}', (string) $tahun, $butir['label']);
    }
}
unset($butir);

return [
    'zona_waktu' => 'Asia/Jakarta',

    // Dipakai di halaman depan dan dashboard Peserta: config('jadwal.tahun').
    'tahun' => $tahun,

    'tahap' => $tahap,
];