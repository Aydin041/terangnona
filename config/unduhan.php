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
| Nama berkas saat diunduh dibuat dari 'nama_unduhan' (lengkap dengan ekstensi).
| Nama itu ditulis eksplisit supaya tanda "/" pada judul tidak merusak nama berkas.
|
*/

return [
    'folder' => 'unduhan',

    'kelompok' => [
        'Panduan' => [
            [
                'judul' => 'SK dan Panduan Kompetisi TERANG NONA {tahun}',
                'deskripsi' => 'Surat Keputusan kompetisi',
                'berkas' => 'sk-terang-nona-2026.pdf',
                'nama_unduhan' => 'SK dan Panduan Kompetisi TERANG NONA 2026.pdf',
            ],
            [
                'judul' => 'Perubahan Jadwal TERANG NONA {tahun}',
                'deskripsi' => 'Nota Dinas perubahan jadwal kompetisi',
                'berkas' => 'perubahan-jadwal-terang-nona-2026.pdf',
                'nama_unduhan' => 'Perubahan Jadwal TERANG NONA 2026.pdf',
            ],
        ],

        'Template Dokumen Pendaftaran' => [
            [
                'judul' => 'Format Surat Pernyataan Komitmen/Implementasi Inovasi - TERANG NONA {tahun}',
                'deskripsi' => 'Template untuk diisi dan ditandatangani',
                'berkas' => 'format-surat-pernyataan-komitmen-implementasi-inovasi.docx',
                'nama_unduhan' => 'Format Surat Pernyataan Komitmen Implementasi Inovasi - TERANG NONA 2026.docx',
            ],
            [
                'judul' => 'Format Surat Pernyataan Identitas Inovator - TERANG NONA {tahun}',
                'deskripsi' => 'Template untuk diisi dan ditandatangani',
                'berkas' => 'format-surat-pernyataan-identitas-inovator.docx',
                'nama_unduhan' => 'Format Surat Pernyataan Identitas Inovator - TERANG NONA 2026.docx',
            ],
        ],
    ],
];