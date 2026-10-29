<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Peserta\PengajuanController as PesertaPengajuanController;
use App\Models\IsianProposal;
use App\Models\KomponenPenilaian;
use App\Models\Pengajuan;
use Illuminate\Http\Request;

/**
 * Hanya-lihat. Sengaja tidak ada method yang menulis/mengubah data.
 */
class PengajuanController extends Controller
{
    private const STATUS_FILTER = ['menunggu_pemeriksaan', 'disetujui', 'perlu_perbaikan', 'ditolak'];

    public function index(Request $request)
    {
        $status = $request->query('status');
        if (! in_array($status, self::STATUS_FILTER, true)) {
            $status = null;
        }

        // Draft (belum dikirim peserta) tidak ditampilkan ke Pimpinan.
        $query = Pengajuan::with('peserta', 'kategori')->where('status', '!=', 'draft');

        if ($status) {
            $query->where('status', $status);
        }

        $daftarPengajuan = $query->orderBy('created_at', 'desc')->get();

        return view('pimpinan.pengajuan.index', compact('daftarPengajuan', 'status'));
    }

    public function detail($id)
    {
        $pengajuan = Pengajuan::with('peserta', 'kategori', 'anggotaKelompok', 'dokumen')
            ->findOrFail($id);

        if ($pengajuan->status === 'draft') {
            abort(404);
        }

        $dokumenPerJenis = $pengajuan->dokumen->keyBy('jenis_dokumen');

        $isianPerKomponen = IsianProposal::with('links')
            ->where('pengajuan_id', $pengajuan->id)
            ->get()
            ->keyBy('komponen_id');

        // Komponen yang tidak berlaku untuk bentuk Eksisting disembunyikan
        // (aturan yang sama dengan penghitungan nilai di RankingService).
        $komponenList = KomponenPenilaian::orderBy('id')->get()
            ->filter(fn ($k) => $k->kolom_target === 'keduanya' || $pengajuan->bentuk_inovasi !== 'eksisting')
            ->values();

        $lampiranUtama = PesertaPengajuanController::KOMPONEN_LAMPIRAN;
        $lampiranTambahan = PesertaPengajuanController::KOMPONEN_LAMPIRAN_TAMBAHAN;

        // Alasan penolakan/pengembalian dan riwayat pemeriksaan Panitia.
        $riwayat = $pengajuan->riwayatStatus()->with('panitia')->orderBy('id')->get();
        $catatanTerakhir = $riwayat->where('status', $pengajuan->status)->last()?->catatan_panitia;

        return view('pimpinan.pengajuan.detail', compact(
            'pengajuan', 'dokumenPerJenis', 'isianPerKomponen', 'komponenList', 'lampiranUtama', 'lampiranTambahan',
            'riwayat', 'catatanTerakhir'
        ));
    }
}