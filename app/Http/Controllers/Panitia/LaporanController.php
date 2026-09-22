<?php

namespace App\Http\Controllers\Panitia;

use App\Http\Controllers\Controller;
use App\Services\NilaiReportService;

class LaporanController extends Controller
{
    public function index(NilaiReportService $service)
    {
        $laporan = $service->ambilData();
        return view('panitia.laporan.index', compact('laporan'));
    }
}