<?php

/*
 * Pengaturan tambahan untuk captcha (paket mews/captcha).
 * Hanya menambah satu "preset" bernama login; pengaturan bawaan paket tidak diubah.
 * Preset ini memakai soal penjumlahan sederhana (misalnya "17 + 6 = ") supaya mudah dibaca.
 */
return [
    'login' => [
        // 'length' harus 9: soal "23 + 5 = " terdiri dari 9 karakter, dan paket ini memakai
        // angka itu untuk membagi lebar gambar. Kalau lebih kecil, sebagian soal terpotong.
        'length' => 9,
        'width' => 260,
        'height' => 44,
        'quality' => 90,
        'math' => true,
        'sensitive' => false,
        'encrypt' => false,
        'bgImage' => false,
        'bgColor' => '#ffffff',
        'lines' => 3,
        'angle' => 6,
        'fontColors' => ['#1e293b', '#1d4ed8', '#15803d'],
    ],
];