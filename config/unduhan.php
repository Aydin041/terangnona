<?php

/*
|--------------------------------------------------------------------------
| Daftar berkas di halaman Download
|--------------------------------------------------------------------------
|
| Letakkan berkasnya di folder public/unduhan dengan nama persis seperti di
| kolom 'berkas'. Kalau berkas belum ada, tombolnya tampil "Belum tersedia".
| Jenis (PDF atau Word) dibaca dari ekstensi berkas. {tahun} diganti tahun kompetisi.
|
| Nama berkas saat diunduh otomatis dibuat dari 'judul' (contoh: "Panduan Kompetisi
| TERANG NONA 2026.pdf"). Kalau ingin nama lain, tambahkan 'nama_unduhan' => '...' pada
| item yang bersangkutan, lengkap dengan ekstensinya.
|
*/

return [
    'folder' => 'unduhan',

    'kelompok' => [
        'Panduan' => [
            [
                'judul' => 'Panduan Kompetisi TERANG NONA {tahun}',
                'deskripsi' => 'Ketentuan, jadwal, dan kriteria penilaian',
                'berkas' => 'panduan-kompetisi.pdf',
            ],
        ],

        'Template Dokumen Pendaftaran' => [
            [
                'judul' => 'Surat Pernyataan Identitas Inovator',
                'deskripsi' => 'Template untuk diisi dan ditandatangani',
                'berkas' => 'surat-pernyataan-identitas-inovator.docx',
            ],
            [
                'judul' => 'Surat Pernyataan Implementasi Inovasi',
                'deskripsi' => 'Template untuk diisi dan ditandatangani',
                'berkas' => 'surat-pernyataan-implementasi-inovasi.docx',
            ],
            [
                'judul' => 'Surat Pernyataan Komitmen Implementasi Inovasi',
                'deskripsi' => 'Template untuk diisi dan ditandatangani',
                'berkas' => 'surat-pernyataan-komitmen-implementasi-inovasi.docx',
            ],
            [
                'judul' => 'Template Rencana Aksi / Pengembangan',
                'deskripsi' => 'Lampiran Bagian C pengajuan',
                'berkas' => 'template-rencana-aksi-pengembangan.docx',
            ],
        ],
    ],
];