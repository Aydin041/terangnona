<?php

namespace App\Http\Controllers\Panitia;

use App\Http\Controllers\Controller;
use App\Services\RankingService;

class RankingController extends Controller
{
    public function index()
    {
        $rankingService = new RankingService();
        $ranking = $rankingService->rankingPerKelompok();
        $idLolos5Besar = $rankingService->idPengajuanLolos5Besar();

        return view('panitia.ranking.index', compact('ranking', 'idLolos5Besar'));
    }
}