<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use App\Services\RankingService;

class RankingController extends Controller
{
    public function index()
    {
        $rankingService = new RankingService();

        $ranking = $rankingService->rankingPerKelompok();
        $idLolos5Besar = $rankingService->idPengajuanLolos5Besar();

        $rankingAkhir = $rankingService->rankingAkhirPerKelompok();
        $id3Besar = $rankingService->idPengajuan3Besar();

        return view('pimpinan.ranking.index', compact(
            'ranking', 'idLolos5Besar', 'rankingAkhir', 'id3Besar'
        ));
    }
}