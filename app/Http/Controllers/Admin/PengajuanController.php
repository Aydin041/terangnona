<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use App\Services\PenghapusanData;
use Illuminate\Http\Request;

class PengajuanController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $cari = trim((string) $request->query('q'));

        $query = Pengajuan::with('peserta', 'kategori');

        if ($status) {
            $query->where('status', $status);
        }

        if ($cari !== '') {
            $query->where(function ($q) use ($cari) {
                $q->where('nama_inovasi', 'like', "%{$cari}%")
                    ->orWhere('akronim', 'like', "%{$cari}%")
                    ->orWhereHas('peserta', fn ($p) => $p->where('nama', 'like', "%{$cari}%"));
            });
        }

        $daftarPengajuan = $query->orderBy('created_at', 'desc')->get();

        return view('admin.pengajuan.index', compact('daftarPengajuan', 'status', 'cari'));
    }

    public function hapusForm($id, PenghapusanData $penghapusan)
    {
        $pengajuan = Pengajuan::with('peserta')->findOrFail($id);

        return view('admin.hapus.konfirmasi', [
            'judul' => 'Hapus Pengajuan',
            'nama' => "{$pengajuan->nama_inovasi} ({$pengajuan->akronim})",
            'sub' => 'Peserta: ' . $pengajuan->peserta->nama . ' | Status: ' . $pengajuan->status,
            'ringkasan' => $penghapusan->ringkasanPengajuan($pengajuan->id),
            'action' => route('admin.pengajuan.hapus', $pengajuan->uuid),
            'batal' => route('admin.pengajuan.index'),
        ]);
    }

    public function hapus(Request $request, $id, PenghapusanData $penghapusan)
    {
        $request->validate(
            ['konfirmasi' => 'required|in:HAPUS'],
            ['konfirmasi.*' => 'Ketik HAPUS (huruf besar semua) untuk melanjutkan.']
        );

        $pengajuan = Pengajuan::findOrFail($id);
        $nama = $pengajuan->nama_inovasi;

        $penghapusan->hapusPengajuan($pengajuan->id);

        return redirect()->route('admin.pengajuan.index')
            ->with('sukses', "Pengajuan \"{$nama}\" berhasil dihapus permanen beserta nilai dan datanya.");
    }
}