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
| BERKAS KE-4: nama dan jenisnya masih menunggu. Kalau sudah jadi, ganti
| 'judul', 'deskripsi', 'berkas', dan 'nama_unduhan' pada item bertanda TODO,
| lalu letakkan filenya di public/unduhan.
|
*/

return [
    'folder' => 'unduhan',

    'kelompok' => [
        'Panduan' => [
            [
                'judul' => 'SK TERANG NONA {tahun}',
                'deskripsi' => 'Surat Keputusan kompetisi',
                'berkas' => 'sk-terang-nona-2026.pdf',
                'nama_unduhan' => 'SK Terang Nona 2026.pdf',
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
            [
                // TODO: ganti setelah nama dan jenis berkas ke-4 pasti.
                'judul' => 'Dokumen Tambahan (menyusul)',
                'deskripsi' => 'Sedang dalam proses',
                'berkas' => 'berkas-ke-4.pdf',
                'nama_unduhan' => 'Berkas ke-4.pdf',
            ],
        ],
    ],
];