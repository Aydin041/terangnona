<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SurveiPartisipasi;
use App\Services\SurveiService;

class SurveiController extends Controller
{
    public function index()
    {
        return view('admin.survei.index', [
            'ringkasan' => SurveiService::ringkasan(),
            'jumlahLayak' => SurveiService::pesertaLayak()->count(),
        ]);
    }

    /**
     * Daftar siapa yang sudah dan belum mengisi. Tidak memuat jawaban dan tidak memuat waktu.
     */
    public function partisipasi()
    {
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