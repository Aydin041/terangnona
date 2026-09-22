<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    public function form()
    {
        $pengaturan = Pengaturan::ambil();
        return view('admin.pengaturan.index', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'deadline_pengajuan' => 'nullable|date',
        ]);

        $pengaturan = Pengaturan::ambil();
        $pengaturan->update([
            'deadline_pengajuan' => $validated['deadline_pengajuan'] ?? null,
        ]);

        return back()->with('sukses', 'Deadline pengajuan berhasil disimpan.');
    }
}