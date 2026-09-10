<?php

namespace App\Http\Controllers\Panitia;

use App\Http\Controllers\Controller;
use App\Models\AnggotaKelompok;
use App\Models\Pengajuan;
use App\Models\RiwayatStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');

        $query = Pengajuan::with('peserta', 'kategori');

        if ($status) {
            $query->where('status', $status);
        }

        $daftarPengajuan = $query->orderBy('created_at', 'desc')->get();

        return view('panitia.pengajuan.index', compact('daftarPengajuan', 'status'));
    }

    public function detail($id)
    {
        $pengajuan = Pengajuan::with('peserta', 'kategori', 'anggotaKelompok', 'dokumen')
            ->findOrFail($id);

        // Cari peringatan kemiripan nama (BR01) — bukan blocking, cuma informasi utk Panitia
        $namaAnggotaIni = $pengajuan->anggotaKelompok->pluck('nama')->map(function ($nama) {
            return strtolower(trim($nama));
        });

        $peringatanDuplikasi = [];
        $kandidatMirip = AnggotaKelompok::where('pengajuan_id', '!=', $pengajuan->id)
            ->get();

        foreach ($kandidatMirip as $kandidat) {
            $namaKandidat = strtolower(trim($kandidat->nama));
            if ($namaAnggotaIni->contains($namaKandidat)) {
                $pengajuanLain = Pengajuan::find($kandidat->pengajuan_id);
                if ($pengajuanLain) {
                    $peringatanDuplikasi[$pengajuanLain->id] = $pengajuanLain->nama_inovasi . ' (' . $kandidat->nama . ')';
                }
            }
        }

        return view('panitia.pengajuan.detail', compact('pengajuan', 'peringatanDuplikasi'));
    }

    public function setujui($id)
    {
        $panitia = Auth::guard('panitia')->user();
        $pengajuan = Pengajuan::findOrFail($id);

        $pengajuan->update(['status' => 'disetujui']);

        RiwayatStatus::create([
            'pengajuan_id' => $pengajuan->id,
            'status' => 'disetujui',
            'catatan_panitia' => null,
            'panitia_id' => $panitia->id,
            'changed_at' => now(),
        ]);

        return redirect()->route('panitia.pengajuan.index')->with('sukses', 'Pengajuan disetujui.');
    }

    public function kembalikan(Request $request, $id)
    {
        $validated = $request->validate([
            'catatan_panitia' => 'required|string|max:1000',
        ]);

        $panitia = Auth::guard('panitia')->user();
        $pengajuan = Pengajuan::findOrFail($id);

        $pengajuan->update(['status' => 'perlu_perbaikan']);

        RiwayatStatus::create([
            'pengajuan_id' => $pengajuan->id,
            'status' => 'perlu_perbaikan',
            'catatan_panitia' => $validated['catatan_panitia'],
            'panitia_id' => $panitia->id,
            'changed_at' => now(),
        ]);

        return redirect()->route('panitia.pengajuan.index')->with('sukses', 'Pengajuan dikembalikan ke peserta.');
    }
}