<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use App\Services\SurveiService;

class SurveiController extends Controller
{
    public function index()
    {
        return view('pimpinan.survei.index', [
            'ringkasan' => SurveiService::ringkasan(),
            'jumlahLayak' => SurveiService::pesertaLayak()->count(),
        ]);
    }
}