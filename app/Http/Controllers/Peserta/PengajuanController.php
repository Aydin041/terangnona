<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\KomponenPenilaian;
use App\Models\IsianProposal;
use App\Models\Pengajuan;
use App\Models\RiwayatStatus;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanController extends Controller
{
    public function dashboard()
    {
        $peserta = Auth::guard('peserta')->user();
        $daftarPengajuan = Pengajuan::where('peserta_id', $peserta->id)->get();

        $catatanPengembalian = [];
        foreach ($daftarPengajuan as $item) {
            if ($item->status === 'perlu_perbaikan') {
                $riwayatTerakhir = RiwayatStatus::where('pengajuan_id', $item->id)
                    ->where('status', 'perlu_perbaikan')
                    ->orderBy('id', 'desc')
                    ->first();

                if ($riwayatTerakhir) {
                    $catatanPengembalian[$item->id] = $riwayatTerakhir->catatan_panitia;
                }
            }
        }

        return view('peserta.pengajuan.dashboard', compact('daftarPengajuan', 'catatanPengembalian'));
    }

    public function step1Form($pengajuanId = null)
    {
        $kategoriList = Kategori::all();
        $unitKerjaList = UnitKerja::orderBy('nama')->get();
        $pengajuan = null;

        if ($pengajuanId) {
            $peserta = Auth::guard('peserta')->user();
            $pengajuan = Pengajuan::where('id', $pengajuanId)
                ->where('peserta_id', $peserta->id)
                ->firstOrFail();
        }

        return view('peserta.pengajuan.step1', compact('kategoriList', 'unitKerjaList', 'pengajuan'));
    }

    public function step1Store(Request $request, $pengajuanId = null)
    {
        $validated = $request->validate([
            'nama_inovasi' => 'required|string|max:255',
            'akronim' => 'required|string|max:50',
            'kategori_id' => 'required|exists:kategori,id',
            'unit_kerja_id' => 'required|exists:unit_kerja,id',
            'tahun_implementasi' => 'required|integer|min:2020|max:2030',
        ]);

        $peserta = Auth::guard('peserta')->user();

        if ($pengajuanId) {
            $pengajuan = Pengajuan::where('id', $pengajuanId)
                ->where('peserta_id', $peserta->id)
                ->firstOrFail();

            $pengajuan->update($validated);
        } else {
            $pengajuan = Pengajuan::create([
                'peserta_id' => $peserta->id,
                'kategori_id' => $validated['kategori_id'],
                'unit_kerja_id' => $validated['unit_kerja_id'],
                'nama_inovasi' => $validated['nama_inovasi'],
                'akronim' => $validated['akronim'],
                'tahun_implementasi' => $validated['tahun_implementasi'],
                'bentuk_inovasi' => 'belum_dipilih',
                'deskripsi' => '',
                'status' => 'draft',
            ]);
        }

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

    public function step3Form($pengajuanId)
    {
        $peserta = Auth::guard('peserta')->user();
        $pengajuan = Pengajuan::where('id', $pengajuanId)
            ->where('peserta_id', $peserta->id)
            ->firstOrFail();

        $anggotaLain = $pengajuan->anggotaKelompok()->where('adalah_ketua', false)->get();

        return view('peserta.pengajuan.step3', compact('pengajuan', 'peserta', 'anggotaLain'));
    }

    public function step3Store(Request $request, $pengajuanId)
    {
        $peserta = Auth::guard('peserta')->user();
        $pengajuan = Pengajuan::where('id', $pengajuanId)
            ->where('peserta_id', $peserta->id)
            ->firstOrFail();

        $request->validate([
            'anggota_nama' => 'array',
            'anggota_nama.*' => 'nullable|string|max:255',
            'anggota_kontak' => 'array',
            'anggota_kontak.*' => 'nullable|string|max:20',
        ]);

        $pengajuan->anggotaKelompok()->delete();

        $pengajuan->anggotaKelompok()->create([
            'nama' => $peserta->nama,
            'kontak' => $peserta->kontak,
            'adalah_ketua' => true,
        ]);

        $namaList = $request->input('anggota_nama', []);
        $kontakList = $request->input('anggota_kontak', []);

        foreach ($namaList as $index => $nama) {
            if (!empty($nama)) {
                $pengajuan->anggotaKelompok()->create([
                    'nama' => $nama,
                    'kontak' => $kontakList[$index] ?? '',
                    'adalah_ketua' => false,
                ]);
            }
        }

        return redirect()->route('peserta.pengajuan.step4', $pengajuan->id);
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

    public function step4Form($pengajuanId)
    {
        $peserta = Auth::guard('peserta')->user();
        $pengajuan = Pengajuan::where('id', $pengajuanId)
            ->where('peserta_id', $peserta->id)
            ->firstOrFail();

        $dokumenTersimpan = $pengajuan->dokumen()->get()->keyBy('jenis_dokumen');

        $komponenList = $this->komponenBerlaku($pengajuan);
        foreach ($komponenList as $komponen) {
            IsianProposal::firstOrCreate(
                ['pengajuan_id' => $pengajuan->id, 'komponen_id' => $komponen->id],
                ['uraian' => null, 'link_bukti_dukung' => null]
            );
        }
        $isianTersimpan = IsianProposal::where('pengajuan_id', $pengajuan->id)
            ->get()
            ->keyBy('komponen_id');

        return view('peserta.pengajuan.step4', compact('pengajuan', 'dokumenTersimpan', 'komponenList', 'isianTersimpan'));
    }

    public function step4Store(Request $request, $pengajuanId)
    {
        $peserta = Auth::guard('peserta')->user();
        $pengajuan = Pengajuan::where('id', $pengajuanId)
            ->where('peserta_id', $peserta->id)
            ->firstOrFail();

        $rules = [
            'surat_identitas' => 'nullable|file|mimes:pdf|max:10240',
            'video_link' => 'required|url',
            'uraian' => 'array',
            'link_bukti_dukung' => 'array',
        ];

        if ($pengajuan->bentuk_inovasi === 'eksisting') {
            $rules['surat_implementasi'] = 'nullable|file|mimes:pdf|max:10240';
        } else {
            $rules['surat_komitmen'] = 'nullable|file|mimes:pdf|max:10240';
        }

        $validated = $request->validate($rules);

        $pengajuan->dokumen()->updateOrCreate(
            ['jenis_dokumen' => 'video_link'],
            ['file_path' => $validated['video_link'], 'uploaded_at' => now()]
        );

        $jenisFileList = ['surat_identitas'];
        $jenisFileList[] = $pengajuan->bentuk_inovasi === 'eksisting' ? 'surat_implementasi' : 'surat_komitmen';

        foreach ($jenisFileList as $jenis) {
            if ($request->hasFile($jenis)) {
                $file = $request->file($jenis);
                $namaAsli = $file->getClientOriginalName();
                $path = $file->store('dokumen_pengajuan', 'public');

                $pengajuan->dokumen()->updateOrCreate(
                    ['jenis_dokumen' => $jenis],
                    ['nama_asli' => $namaAsli, 'file_path' => $path, 'uploaded_at' => now()]
                );
            }
        }

        $uraianInput = $request->input('uraian', []);
        $linkInput = $request->input('link_bukti_dukung', []);

        foreach ($uraianInput as $komponenId => $uraian) {
            IsianProposal::updateOrCreate(
                ['pengajuan_id' => $pengajuan->id, 'komponen_id' => $komponenId],
                [
                    'uraian' => $uraian,
                    'link_bukti_dukung' => $linkInput[$komponenId] ?? null,
                ]
            );
        }

        return redirect()->route('peserta.pengajuan.step5', $pengajuan->id);
    }

    private function daftarDokumenWajib($pengajuan)
    {
        $wajib = ['surat_identitas'];
        $wajib[] = $pengajuan->bentuk_inovasi === 'eksisting' ? 'surat_implementasi' : 'surat_komitmen';
        $wajib[] = 'video_link';
        return $wajib;
    }

    public function step5Form($pengajuanId)
    {
        $peserta = Auth::guard('peserta')->user();
        $pengajuan = Pengajuan::where('id', $pengajuanId)
            ->where('peserta_id', $peserta->id)
            ->firstOrFail();

        $anggotaKelompok = $pengajuan->anggotaKelompok()->get();
        $dokumenTersimpan = $pengajuan->dokumen()->get()->keyBy('jenis_dokumen');

        $dokumenWajib = $this->daftarDokumenWajib($pengajuan);
        $dokumenBelumLengkap = [];
        foreach ($dokumenWajib as $jenis) {
            if (!isset($dokumenTersimpan[$jenis])) {
                $dokumenBelumLengkap[] = $jenis;
            }
        }

        $komponenList = $this->komponenBerlaku($pengajuan);
        $isianTersimpan = IsianProposal::where('pengajuan_id', $pengajuan->id)->get()->keyBy('komponen_id');
        $isianBelumLengkap = [];
        foreach ($komponenList as $komponen) {
            $isian = $isianTersimpan[$komponen->id] ?? null;
            if (!$isian || empty($isian->uraian)) {
                $isianBelumLengkap[] = $komponen->nama;
            }
        }

        return view('peserta.pengajuan.step5', compact(
            'pengajuan', 'anggotaKelompok', 'dokumenTersimpan', 'dokumenBelumLengkap', 'isianBelumLengkap'
        ));
    }

    public function step5Store($pengajuanId)
    {
        $peserta = Auth::guard('peserta')->user();
        $pengajuan = Pengajuan::where('id', $pengajuanId)
            ->where('peserta_id', $peserta->id)
            ->firstOrFail();

        $dokumenTersimpan = $pengajuan->dokumen()->get()->keyBy('jenis_dokumen');
        $dokumenWajib = $this->daftarDokumenWajib($pengajuan);

        foreach ($dokumenWajib as $jenis) {
            if (!isset($dokumenTersimpan[$jenis])) {
                return back()->withErrors([
                    'dokumen' => 'Masih ada dokumen wajib yang belum lengkap. Silakan lengkapi dulu di Langkah 4.',
                ]);
            }
        }

        $komponenList = $this->komponenBerlaku($pengajuan);
        $isianTersimpan = IsianProposal::where('pengajuan_id', $pengajuan->id)->get()->keyBy('komponen_id');
        foreach ($komponenList as $komponen) {
            $isian = $isianTersimpan[$komponen->id] ?? null;
            if (!$isian || empty($isian->uraian)) {
                return back()->withErrors([
                    'isian' => 'Masih ada isian komponen proposal yang belum lengkap. Silakan lengkapi dulu di Langkah 4.',
                ]);
            }
        }

        $pengajuan->update(['status' => 'menunggu_pemeriksaan']);

        RiwayatStatus::create([
            'pengajuan_id' => $pengajuan->id,
            'status' => 'menunggu_pemeriksaan',
            'catatan_panitia' => null,
            'panitia_id' => null,
            'changed_at' => now(),
        ]);

        return redirect()->route('peserta.dashboard')->with('sukses', 'Pengajuan berhasil disubmit dan menunggu pemeriksaan Panitia.');
    }
}