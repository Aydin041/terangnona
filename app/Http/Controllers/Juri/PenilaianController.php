<?php

namespace App\Http\Controllers\Juri;

use App\Http\Controllers\Controller;
use App\Models\KomponenPenilaian;
use App\Models\NilaiKomponenProposal;
use App\Models\Pengajuan;
use App\Models\SubmissionProposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenilaianController extends Controller
{
    public function index()
    {
        $juri = Auth::guard('juri')->user();

        $daftarPengajuan = Pengajuan::where('status', 'disetujui')
            ->with('kategori')
            ->orderBy('created_at', 'desc')
            ->get();

        $statusPenilaian = [];
        foreach ($daftarPengajuan as $item) {
            $submission = SubmissionProposal::where('pengajuan_id', $item->id)
                ->where('juri_id', $juri->id)
                ->first();

            $statusPenilaian[$item->id] = $submission ? $submission->status : 'belum_dinilai';
        }

        return view('juri.penilaian.index', compact('daftarPengajuan', 'statusPenilaian'));
    }

    private function komponenBerlaku($pengajuan)
    {
        return KomponenPenilaian::all()->filter(function ($komponen) use ($pengajuan) {
            if ($komponen->kolom_target === 'keduanya') {
                return true;
            }
            // kolom_target = 'rancangan_inovasi' -> hanya berlaku utk pengembangan/rancangan
            return $pengajuan->bentuk_inovasi !== 'eksisting';
        });
    }

    public function proposalForm($pengajuanId)
    {
        $juri = Auth::guard('juri')->user();
        $pengajuan = Pengajuan::findOrFail($pengajuanId);

        $submission = SubmissionProposal::firstOrCreate(
            ['pengajuan_id' => $pengajuan->id, 'juri_id' => $juri->id],
            ['status' => 'draft']
        );

        $komponenList = $this->komponenBerlaku($pengajuan);

        foreach ($komponenList as $komponen) {
            $nilaiRow = NilaiKomponenProposal::firstOrCreate(
                ['submission_id' => $submission->id, 'komponen_id' => $komponen->id],
                ['nilai' => null, 'komentar' => null, 'terkunci' => false]
            );

            // Aturan: Rencana Aksi utk Eksisting tidak muncul di komponenBerlaku (sudah difilter),
            // jadi baris ini otomatis TIDAK dibuat utk Eksisting — nilai 100 dihitung terpisah saat rekap nanti.
        }

        $nilaiTersimpan = NilaiKomponenProposal::where('submission_id', $submission->id)
            ->get()
            ->keyBy('komponen_id');

        return view('juri.penilaian.proposal', compact(
            'pengajuan', 'submission', 'komponenList', 'nilaiTersimpan'
        ));
    }

    public function proposalDraft(Request $request, $pengajuanId)
    {
        $juri = Auth::guard('juri')->user();
        $pengajuan = Pengajuan::findOrFail($pengajuanId);

        $submission = SubmissionProposal::where('pengajuan_id', $pengajuan->id)
            ->where('juri_id', $juri->id)
            ->firstOrFail();

        if ($submission->status === 'submitted') {
            return back()->withErrors(['umum' => 'Penilaian sudah disubmit dan terkunci, tidak bisa diubah.']);
        }

        $nilaiInput = $request->input('nilai', []);
        $komentarInput = $request->input('komentar', []);

        foreach ($nilaiInput as $komponenId => $nilai) {
            NilaiKomponenProposal::where('submission_id', $submission->id)
                ->where('komponen_id', $komponenId)
                ->where('terkunci', false)
                ->update([
                    'nilai' => $nilai !== '' ? $nilai : null,
                    'komentar' => $komentarInput[$komponenId] ?? null,
                ]);
        }

        return back()->with('sukses', 'Draft berhasil disimpan.');
    }

    public function proposalSubmit(Request $request, $pengajuanId)
    {
        $juri = Auth::guard('juri')->user();
        $pengajuan = Pengajuan::findOrFail($pengajuanId);

        $submission = SubmissionProposal::where('pengajuan_id', $pengajuan->id)
            ->where('juri_id', $juri->id)
            ->firstOrFail();

        if ($submission->status === 'submitted') {
            return back()->withErrors(['umum' => 'Penilaian sudah pernah disubmit.']);
        }

        $nilaiInput = $request->input('nilai', []);
        $komentarInput = $request->input('komentar', []);

        $komponenList = $this->komponenBerlaku($pengajuan);

        // Validasi: semua komponen yang berlaku wajib ada nilainya sebelum submit final
        foreach ($komponenList as $komponen) {
            $nilai = $nilaiInput[$komponen->id] ?? null;
            if ($nilai === null || $nilai === '') {
                return back()->withErrors([
                    'umum' => 'Semua komponen wajib diisi nilainya sebelum submit final. Simpan sebagai draft dulu kalau belum selesai.',
                ]);
            }
            if ($nilai < 0 || $nilai > 100) {
                return back()->withErrors(['umum' => 'Nilai harus antara 0-100.']);
            }
        }

        foreach ($nilaiInput as $komponenId => $nilai) {
            NilaiKomponenProposal::where('submission_id', $submission->id)
                ->where('komponen_id', $komponenId)
                ->update([
                    'nilai' => $nilai,
                    'komentar' => $komentarInput[$komponenId] ?? null,
                    'terkunci' => true,
                ]);
        }

        $submission->update([
            'status' => 'submitted',
            'submitted_at' => now(),
        ]);

        return redirect()->route('juri.penilaian.index')->with('sukses', 'Penilaian proposal berhasil disubmit dan terkunci.');
    }
}