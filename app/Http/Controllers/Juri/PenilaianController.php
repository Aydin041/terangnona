<?php

namespace App\Http\Controllers\Juri;

use App\Http\Controllers\Controller;
use App\Models\KomponenPenilaian;
use App\Models\NilaiAspekPresentasi;
use App\Models\NilaiKomponenProposal;
use App\Models\Pengajuan;
use App\Models\SubmissionPresentasi;
use App\Models\SubmissionProposal;
use App\Services\RankingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenilaianController extends Controller
{
    const ASPEK_PRESENTASI = [
        'teknik_penyajian' => 'Teknik Penyajian & Penguasaan Materi',
        'substansi_materi' => 'Substansi Materi & Kelengkapan Data',
        'komitmen_pimpinan' => 'Komitmen & Dukungan Pimpinan',
    ];

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

        $rankingService = new RankingService();
        $idLolos5Besar = $rankingService->idPengajuanLolos5Besar();

        return view('juri.penilaian.index', compact('daftarPengajuan', 'statusPenilaian', 'idLolos5Besar'));
    }

    private function komponenBerlaku($pengajuan)
    {
        return KomponenPenilaian::all()->filter(function ($komponen) use ($pengajuan) {
            if ($komponen->kolom_target === 'keduanya') {
                return true;
            }
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
            NilaiKomponenProposal::firstOrCreate(
                ['submission_id' => $submission->id, 'komponen_id' => $komponen->id],
                ['nilai' => null, 'komentar' => null, 'terkunci' => false]
            );
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

    public function presentasiForm($pengajuanId)
    {
        $juri = Auth::guard('juri')->user();
        $pengajuan = Pengajuan::findOrFail($pengajuanId);

        $rankingService = new RankingService();
        $idLolos5Besar = $rankingService->idPengajuanLolos5Besar();

        if (!in_array($pengajuan->id, $idLolos5Besar)) {
            abort(403, 'Pengajuan ini belum/tidak lolos 5 besar, tidak bisa dinilai presentasinya.');
        }

        $submission = SubmissionPresentasi::firstOrCreate(
            ['pengajuan_id' => $pengajuan->id, 'juri_id' => $juri->id],
            ['status' => 'draft']
        );

        foreach (self::ASPEK_PRESENTASI as $kode => $label) {
            NilaiAspekPresentasi::firstOrCreate(
                ['submission_id' => $submission->id, 'aspek' => $kode],
                ['nilai' => null, 'catatan' => null, 'terkunci' => false]
            );
        }

        $nilaiTersimpan = NilaiAspekPresentasi::where('submission_id', $submission->id)
            ->get()
            ->keyBy('aspek');

        $aspekList = self::ASPEK_PRESENTASI;

        return view('juri.penilaian.presentasi', compact(
            'pengajuan', 'submission', 'aspekList', 'nilaiTersimpan'
        ));
    }

    public function presentasiDraft(Request $request, $pengajuanId)
    {
        $juri = Auth::guard('juri')->user();
        $pengajuan = Pengajuan::findOrFail($pengajuanId);

        $submission = SubmissionPresentasi::where('pengajuan_id', $pengajuan->id)
            ->where('juri_id', $juri->id)
            ->firstOrFail();

        if ($submission->status === 'submitted') {
            return back()->withErrors(['umum' => 'Penilaian sudah disubmit dan terkunci.']);
        }

        $nilaiInput = $request->input('nilai', []);
        $catatanInput = $request->input('catatan', []);

        foreach ($nilaiInput as $aspek => $nilai) {
            NilaiAspekPresentasi::where('submission_id', $submission->id)
                ->where('aspek', $aspek)
                ->where('terkunci', false)
                ->update([
                    'nilai' => $nilai !== '' ? $nilai : null,
                    'catatan' => $catatanInput[$aspek] ?? null,
                ]);
        }

        return back()->with('sukses', 'Draft berhasil disimpan.');
    }

    public function presentasiSubmit(Request $request, $pengajuanId)
    {
        $juri = Auth::guard('juri')->user();
        $pengajuan = Pengajuan::findOrFail($pengajuanId);

        $submission = SubmissionPresentasi::where('pengajuan_id', $pengajuan->id)
            ->where('juri_id', $juri->id)
            ->firstOrFail();

        if ($submission->status === 'submitted') {
            return back()->withErrors(['umum' => 'Penilaian sudah pernah disubmit.']);
        }

        $nilaiInput = $request->input('nilai', []);
        $catatanInput = $request->input('catatan', []);

        foreach (self::ASPEK_PRESENTASI as $kode => $label) {
            $nilai = $nilaiInput[$kode] ?? null;
            if ($nilai === null || $nilai === '') {
                return back()->withErrors([
                    'umum' => 'Semua aspek wajib diisi nilainya sebelum submit final.',
                ]);
            }
            if ($nilai < 0 || $nilai > 100) {
                return back()->withErrors(['umum' => 'Nilai harus antara 0-100.']);
            }
        }

        foreach ($nilaiInput as $aspek => $nilai) {
            NilaiAspekPresentasi::where('submission_id', $submission->id)
                ->where('aspek', $aspek)
                ->update([
                    'nilai' => $nilai,
                    'catatan' => $catatanInput[$aspek] ?? null,
                    'terkunci' => true,
                ]);
        }

        $submission->update([
            'status' => 'submitted',
            'submitted_at' => now(),
        ]);

        return redirect()->route('juri.penilaian.index')->with('sukses', 'Penilaian presentasi berhasil disubmit dan terkunci.');
    }
}