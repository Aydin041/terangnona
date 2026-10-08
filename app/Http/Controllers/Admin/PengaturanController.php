<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Juri;
use App\Models\Pengaturan;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    public function form()
    {
        $pengaturan = Pengaturan::ambil();
        $jumlahJuri = Juri::count();

        return view('admin.pengaturan.index', compact('pengaturan', 'jumlahJuri'));
    }

    public function update(Request $request)
    {
        $jumlahJuri = max(1, Juri::count());

        $validated = $request->validate([
            'deadline_pengajuan' => 'nullable|date',
            'minimal_juri_submit' => ['required', 'integer', 'min:1', 'max:' . $jumlahJuri],
        ], [
            'minimal_juri_submit.required' => 'Minimal juri wajib diisi.',
            'minimal_juri_submit.integer' => 'Minimal juri harus berupa angka bulat.',
            'minimal_juri_submit.min' => 'Minimal juri tidak boleh kurang dari 1.',
            'minimal_juri_submit.max' => "Minimal juri tidak boleh lebih dari jumlah akun Juri yang ada ({$jumlahJuri}).",
        ]);

        $pengaturan = Pengaturan::ambil();
        $pengaturan->update([
            'deadline_pengajuan' => $validated['deadline_pengajuan'] ?? null,
            'minimal_juri_submit' => (int) $validated['minimal_juri_submit'],
        ]);

        return back()->with('sukses', 'Pengaturan berhasil disimpan.');
    }
}