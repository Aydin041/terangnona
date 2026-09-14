<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NilaiAspekPresentasi;
use App\Models\NilaiKomponenProposal;
use App\Models\PermintaanBukaKunci;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KoreksiController extends Controller
{
    public function index()
    {
        $daftarPermintaan = PermintaanBukaKunci::with('juri', 'pengajuan', 'komponen')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.koreksi.index', compact('daftarPermintaan'));
    }

    public function setujui($id)
    {
        $admin = Auth::guard('admin')->user();
        $permintaan = PermintaanBukaKunci::findOrFail($id);

        if ($permintaan->status_persetujuan !== 'menunggu') {
            return back()->withErrors(['umum' => 'Permintaan ini sudah pernah diproses.']);
        }

        if ($permintaan->tahap === 'proposal') {
            $submission = \App\Models\SubmissionProposal::where('pengajuan_id', $permintaan->pengajuan_id)
                ->where('juri_id', $permintaan->juri_id)
                ->first();

            NilaiKomponenProposal::where('submission_id', $submission->id)
                ->where('komponen_id', $permintaan->komponen_id)
                ->update([
                    'nilai' => null,
                    'komentar' => null,
                    'terkunci' => false,
                ]);
        } else {
            $submission = \App\Models\SubmissionPresentasi::where('pengajuan_id', $permintaan->pengajuan_id)
                ->where('juri_id', $permintaan->juri_id)
                ->first();

            NilaiAspekPresentasi::where('submission_id', $submission->id)
                ->where('aspek', $permintaan->aspek)
                ->update([
                    'nilai' => null,
                    'catatan' => null,
                    'terkunci' => false,
                ]);
        }

        $permintaan->update([
            'status_persetujuan' => 'disetujui',
            'admin_id' => $admin->id,
        ]);

        return redirect()->route('admin.koreksi.index')->with('sukses', 'Permintaan disetujui. Komponen/aspek terkait sudah dibuka dan dikosongkan untuk diisi ulang Juri.');
    }

    public function tolak($id)
    {
        $admin = Auth::guard('admin')->user();
        $permintaan = PermintaanBukaKunci::findOrFail($id);

        if ($permintaan->status_persetujuan !== 'menunggu') {
            return back()->withErrors(['umum' => 'Permintaan ini sudah pernah diproses.']);
        }

        $permintaan->update([
            'status_persetujuan' => 'ditolak',
            'admin_id' => $admin->id,
        ]);

        return redirect()->route('admin.koreksi.index')->with('sukses', 'Permintaan ditolak.');
    }
}