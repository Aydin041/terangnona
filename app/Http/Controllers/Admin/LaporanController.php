<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\NilaiReportService;

class LaporanController extends Controller
{
    public function index(NilaiReportService $service)
    {
        $laporan = $service->ambilData();
        return view('admin.laporan.index', compact('laporan'));
    }
}