<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $pimpinan = Auth::guard('pimpinan')->user();

        return view('pimpinan.dashboard', compact('pimpinan'));
    }
}