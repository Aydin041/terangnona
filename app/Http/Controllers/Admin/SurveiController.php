<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SurveiPartisipasi;
use App\Services\SurveiService;

class SurveiController extends Controller
{
    public function index()
    {
        $ringkasan = SurveiService::ringkasan();

        return view('admin.survei.index', [
            'ringkasan' => $ringkasan,
            'jumlahLayak' => SurveiService::pesertaLayak()->count(),
            'belumMigrasi' => $ringkasan['belumMigrasi'] ?? false,
        ]);
    }

    /**
     * Daftar siapa yang sudah dan belum mengisi. Tidak memuat jawaban dan tidak memuat waktu.
     */
    public function partisipasi()
    {
        // Jika tabel survei belum ada, tampilkan halaman kosong yang aman
        if (! \Illuminate\Support\Facades\Schema::hasTable('survei_partisipasi')) {
            return view('admin.survei.partisipasi', [
                'sudah' => collect(),
                'belum' => collect(),
                'jumlahLayak' => 0,
                'belumMigrasi' => true,
            ]);
        }

        $layak = SurveiService::pesertaLayak()->orderBy('nama')->get(['id', 'nama']);
        $sudahId = SurveiPartisipasi::pluck('peserta_id')->all();

        $sudah = $layak->filter(fn ($p) => in_array($p->id, $sudahId, true))->pluck('nama')->values();
        $belum = $layak->reject(fn ($p) => in_array($p->id, $sudahId, true))->pluck('nama')->values();

        return view('admin.survei.partisipasi', [
            'sudah' => $sudah,
            'belum' => $belum,
            'jumlahLayak' => $layak->count(),
        ]);
    }
}