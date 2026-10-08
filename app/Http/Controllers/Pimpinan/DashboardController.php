<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahPerStatus = Pengajuan::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $jumlahDraft = (int) ($jumlahPerStatus['draft'] ?? 0);
        $totalMasuk = (int) $jumlahPerStatus->except('draft')->sum();

        return view('pimpinan.dashboard', compact('jumlahPerStatus', 'jumlahDraft', 'totalMasuk'));
    }
}