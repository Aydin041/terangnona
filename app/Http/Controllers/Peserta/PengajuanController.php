<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanController extends Controller
{
    public function dashboard()
    {
        $peserta = Auth::guard('peserta')->user();
        $daftarPengajuan = Pengajuan::where('peserta_id', $peserta->id)->get();

        return view('peserta.pengajuan.dashboard', compact('daftarPengajuan'));
    }

    public function step1Form()
    {
        $kategoriList = Kategori::all();
        return view('peserta.pengajuan.step1', compact('kategoriList'));
    }

    public function step1Store(Request $request)
    {
        $validated = $request->validate([
            'nama_inovasi' => 'required|string|max:255',
            'akronim' => 'required|string|max:50',
            'kategori_id' => 'required|exists:kategori,id',
            'tahun_implementasi' => 'required|integer|min:2020|max:2030',
        ]);

        $peserta = Auth::guard('peserta')->user();

        $pengajuan = Pengajuan::create([
            'peserta_id' => $peserta->id,
            'kategori_id' => $validated['kategori_id'],
            'nama_inovasi' => $validated['nama_inovasi'],
            'akronim' => $validated['akronim'],
            'tahun_implementasi' => $validated['tahun_implementasi'],
            'bentuk_inovasi' => 'belum_dipilih', // diisi di Langkah 2
            'deskripsi' => '', // diisi di Langkah 2 (Deskripsi/Ringkasan)
            'status' => 'draft',
        ]);

        return redirect()->route('peserta.pengajuan.step2', $pengajuan->id);
    }
        public function step2Form($pengajuanId)
    {
        $peserta = Auth::guard('peserta')->user();
        $pengajuan = Pengajuan::where('id', $pengajuanId)
            ->where('peserta_id', $peserta->id)
            ->firstOrFail();

        return view('peserta.pengajuan.step2', compact('pengajuan'));
    }

    public function step2Store(Request $request, $pengajuanId)
    {
        $peserta = Auth::guard('peserta')->user();
        $pengajuan = Pengajuan::where('id', $pengajuanId)
            ->where('peserta_id', $peserta->id)
            ->firstOrFail();

        $validated = $request->validate([
            'bentuk_inovasi' => 'required|in:eksisting,pengembangan,rancangan',
        ]);

        $pengajuan->update([
            'bentuk_inovasi' => $validated['bentuk_inovasi'],
        ]);

        return redirect()->route('peserta.pengajuan.step3', $pengajuan->id);
    }
}