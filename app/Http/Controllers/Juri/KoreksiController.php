<?php

namespace App\Http\Controllers\Juri;

use App\Http\Controllers\Controller;
use App\Models\NilaiAspekPresentasi;
use App\Models\NilaiKomponenProposal;
use App\Models\Pengajuan;
use App\Models\PermintaanBukaKunci;
use App\Models\SubmissionPresentasi;
use App\Models\SubmissionProposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KoreksiController extends Controller
{
    const ASPEK_PRESENTASI = [
        'teknik_penyajian' => 'Teknik Penyajian & Penguasaan Materi',
        'substansi_materi' => 'Substansi Materi & Kelengkapan Data',
        'komitmen_pimpinan' => 'Komitmen & Dukungan Pimpinan',
    ];

    public function ajukanProposalForm($pengajuanId)
    {
        $juri = Auth::guard('juri')->user();
        $pengajuan = Pengajuan::findOrFail($pengajuanId);

        $submission = SubmissionProposal::where('pengajuan_id', $pengajuan->id)
            ->where('juri_id', $juri->id)
            ->where('status', 'submitted')
            ->firstOrFail();

        $nilaiTerkunci = NilaiKomponenProposal::where('submission_id', $submission->id)
            ->with('komponen')
            ->get();

        $permintaanAktif = PermintaanBukaKunci::where('juri_id', $juri->id)
            ->where('pengajuan_id', $pengajuan->id)
            ->where('tahap', 'proposal')
            ->where('status_persetujuan', 'menunggu')
            ->pluck('komponen_id')
            ->toArray();

        return view('juri.koreksi.ajukan_proposal', compact(
            'pengajuan', 'nilaiTerkunci', 'permintaanAktif'
        ));
    }

    public function ajukanProposalSubmit(Request $request, $pengajuanId)
    {
        $validated = $request->validate([
            'komponen_id' => 'required|exists:komponen_penilaian,id',
            'alasan' => 'required|string|max:1000',
        ]);

        $juri = Auth::guard('juri')->user();
        $pengajuan = Pengajuan::findOrFail($pengajuanId);

        $sudahAda = PermintaanBukaKunci::where('juri_id', $juri->id)
            ->where('pengajuan_id', $pengajuan->id)
            ->where('tahap', 'proposal')
            ->where('komponen_id', $validated['komponen_id'])
            ->where('status_persetujuan', 'menunggu')
            ->exists();

        if ($sudahAda) {
            return back()->withErrors(['umum' => 'Sudah ada permintaan koreksi untuk komponen ini yang masih menunggu persetujuan Admin.']);
        }

        PermintaanBukaKunci::create([
            'juri_id' => $juri->id,
            'pengajuan_id' => $pengajuan->id,
            'tahap' => 'proposal',
            'komponen_id' => $validated['komponen_id'],
            'aspek' => null,
            'alasan' => $validated['alasan'],
            'status_persetujuan' => 'menunggu',
            'admin_id' => null,
        ]);

        return redirect()
            ->route('juri.penilaian.proposal', $pengajuan->id)
            ->with('sukses', 'Permintaan koreksi berhasil diajukan, menunggu persetujuan Admin.');
    }

    public function ajukanPresentasiForm($pengajuanId)
    {
        $juri = Auth::guard('juri')->user();
        $pengajuan = Pengajuan::findOrFail($pengajuanId);

        $submission = SubmissionPresentasi::where('pengajuan_id', $pengajuan->id)
            ->where('juri_id', $juri->id)
            ->where('status', 'submitted')
            ->firstOrFail();

        $nilaiTerkunci = NilaiAspekPresentasi::where('submission_id', $submission->id)->get();

        $permintaanAktif = PermintaanBukaKunci::where('juri_id', $juri->id)
            ->where('pengajuan_id', $pengajuan->id)
            ->where('tahap', 'presentasi')
            ->where('status_persetujuan', 'menunggu')
            ->pluck('aspek')
            ->toArray();

        $aspekLabel = self::ASPEK_PRESENTASI;

        return view('juri.koreksi.ajukan_presentasi', compact(
            'pengajuan', 'nilaiTerkunci', 'permintaanAktif', 'aspekLabel'
        ));
    }

    public function ajukanPresentasiSubmit(Request $request, $pengajuanId)
    {
        $validated = $request->validate([
            'aspek' => 'required|in:teknik_penyajian,substansi_materi,komitmen_pimpinan',
            'alasan' => 'required|string|max:1000',
        ]);

        $juri = Auth::guard('juri')->user();
        $pengajuan = Pengajuan::findOrFail($pengajuanId);

        $sudahAda = PermintaanBukaKunci::where('juri_id', $juri->id)
            ->where('pengajuan_id', $pengajuan->id)
            ->where('tahap', 'presentasi')
            ->where('aspek', $validated['aspek'])
            ->where('status_persetujuan', 'menunggu')
            ->exists();

        if ($sudahAda) {
            return back()->withErrors(['umum' => 'Sudah ada permintaan koreksi untuk aspek ini yang masih menunggu persetujuan Admin.']);
        }

        PermintaanBukaKunci::create([
            'juri_id' => $juri->id,
            'pengajuan_id' => $pengajuan->id,
            'tahap' => 'presentasi',
            'komponen_id' => null,
            'aspek' => $validated['aspek'],
            'alasan' => $validated['alasan'],
            'status_persetujuan' => 'menunggu',
            'admin_id' => null,
        ]);

        return redirect()
            ->route('juri.penilaian.presentasi', $pengajuan->id)
            ->with('sukses', 'Permintaan koreksi berhasil diajukan, menunggu persetujuan Admin.');
    }
}