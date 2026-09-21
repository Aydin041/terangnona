<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Juri;
use App\Models\NilaiAspekPresentasi;
use App\Models\NilaiKomponenProposal;
use App\Models\Panitia;
use App\Models\Pengajuan;
use App\Models\Peserta;
use App\Models\PermintaanBukaKunci;
use App\Models\RiwayatStatus;
use App\Models\SubmissionPresentasi;
use App\Models\SubmissionProposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AkunController extends Controller
{
    public function panitiaIndex()
    {
        $daftarPanitia = Panitia::orderBy('nama')->get();
        return view('admin.akun.panitia_index', compact('daftarPanitia'));
    }

    public function panitiaCreateForm()
    {
        return view('admin.akun.panitia_create');
    }

    public function panitiaStore(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:panitia,email',
            'password' => 'nullable|string|min:6',
        ]);

        $passwordAsli = !empty($validated['password']) ? $validated['password'] : Str::random(10);

        Panitia::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'password_hash' => Hash::make($passwordAsli),
        ]);

        return redirect()
            ->route('admin.akun.panitia.index')
            ->with('sukses', "Akun Panitia berhasil dibuat. Email: {$validated['email']} | Password: {$passwordAsli} (catat sekarang, tidak akan ditampilkan lagi)");
    }

    public function panitiaResetForm($id)
    {
        $panitia = Panitia::findOrFail($id);
        return view('admin.akun.panitia_reset', compact('panitia'));
    }

    public function panitiaReset(Request $request, $id)
    {
        $validated = $request->validate([
            'password' => 'nullable|string|min:6',
        ]);

        $panitia = Panitia::findOrFail($id);
        $passwordBaru = !empty($validated['password']) ? $validated['password'] : Str::random(10);

        $panitia->update([
            'password_hash' => Hash::make($passwordBaru),
        ]);

        return redirect()
            ->route('admin.akun.panitia.index')
            ->with('sukses', "Password untuk {$panitia->nama} ({$panitia->email}) berhasil direset. Password baru: {$passwordBaru} (catat sekarang, tidak akan ditampilkan lagi)");
    }

    public function panitiaHapus($id)
    {
        $panitia = Panitia::findOrFail($id);

        if (RiwayatStatus::where('panitia_id', $id)->exists()) {
            return back()->withErrors([
                'umum' => "Akun {$panitia->nama} tidak bisa dihapus karena sudah pernah memproses pengajuan (riwayat status tercatat).",
            ]);
        }

        $panitia->delete();

        return redirect()->route('admin.akun.panitia.index')->with('sukses', "Akun Panitia {$panitia->nama} berhasil dihapus.");
    }

    public function juriIndex()
    {
        $daftarJuri = Juri::orderBy('nama')->get();
        return view('admin.akun.juri_index', compact('daftarJuri'));
    }

    public function juriCreateForm()
    {
        return view('admin.akun.juri_create');
    }

    public function juriStore(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:juri,email',
            'password' => 'nullable|string|min:6',
        ]);

        $passwordAsli = !empty($validated['password']) ? $validated['password'] : Str::random(10);

        Juri::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'password_hash' => Hash::make($passwordAsli),
        ]);

        return redirect()
            ->route('admin.akun.juri.index')
            ->with('sukses', "Akun Juri berhasil dibuat. Email: {$validated['email']} | Password: {$passwordAsli} (catat sekarang, tidak akan ditampilkan lagi)");
    }

    public function juriResetForm($id)
    {
        $juri = Juri::findOrFail($id);
        return view('admin.akun.juri_reset', compact('juri'));
    }

    public function juriReset(Request $request, $id)
    {
        $validated = $request->validate([
            'password' => 'nullable|string|min:6',
        ]);

        $juri = Juri::findOrFail($id);
        $passwordBaru = !empty($validated['password']) ? $validated['password'] : Str::random(10);

        $juri->update([
            'password_hash' => Hash::make($passwordBaru),
        ]);

        return redirect()
            ->route('admin.akun.juri.index')
            ->with('sukses', "Password untuk {$juri->nama} ({$juri->email}) berhasil direset. Password baru: {$passwordBaru} (catat sekarang, tidak akan ditampilkan lagi)");
    }

    public function juriHapus($id)
    {
        $juri = Juri::findOrFail($id);

        $sudahMenilai = SubmissionProposal::where('juri_id', $id)->where('status', 'submitted')->exists()
            || SubmissionPresentasi::where('juri_id', $id)->where('status', 'submitted')->exists();

        if ($sudahMenilai) {
            return back()->withErrors([
                'umum' => "Akun {$juri->nama} tidak bisa dihapus karena sudah pernah submit penilaian (proposal atau presentasi).",
            ]);
        }

        // Bersihkan baris draft yang belum pernah disubmit, supaya tidak kena constraint foreign key.
        $submissionProposalIds = SubmissionProposal::where('juri_id', $id)->pluck('id');
        NilaiKomponenProposal::whereIn('submission_id', $submissionProposalIds)->delete();
        SubmissionProposal::where('juri_id', $id)->delete();

        $submissionPresentasiIds = SubmissionPresentasi::where('juri_id', $id)->pluck('id');
        NilaiAspekPresentasi::whereIn('submission_id', $submissionPresentasiIds)->delete();
        SubmissionPresentasi::where('juri_id', $id)->delete();

        PermintaanBukaKunci::where('juri_id', $id)->delete();

        $juri->delete();

        return redirect()->route('admin.akun.juri.index')->with('sukses', "Akun Juri {$juri->nama} berhasil dihapus.");
    }

    public function pesertaIndex()
    {
        $daftarPeserta = Peserta::orderBy('nama')->get();
        return view('admin.akun.peserta_index', compact('daftarPeserta'));
    }

    public function pesertaHapus($id)
    {
        $peserta = Peserta::findOrFail($id);

        $jumlahPengajuan = Pengajuan::where('peserta_id', $id)->count();

        if ($jumlahPengajuan > 0) {
            return back()->withErrors([
                'umum' => "Akun {$peserta->nama} tidak bisa dihapus karena sudah punya {$jumlahPengajuan} pengajuan. Kalau semuanya masih berstatus draft, peserta bisa hapus sendiri lewat dashboard-nya dulu.",
            ]);
        }

        $peserta->delete();

        return redirect()->route('admin.akun.peserta.index')->with('sukses', "Akun Peserta {$peserta->nama} berhasil dihapus.");
    }
}