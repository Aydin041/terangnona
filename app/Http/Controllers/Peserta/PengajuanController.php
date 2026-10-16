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
use Illuminate\Support\Facades\Validator;

class PengajuanController extends Controller
{
    // Komponen #14 (Rencana Aksi) statusnya "LAMPIRKAN DALAM PROPOSAL INI"
    // (upload PDF), bukan uraian+link seperti komponen lain.
    // Rencana Anggaran & Biaya (dulu komponen #15 terpisah) sekarang digabung
    // jadi lampiran tambahan di komponen #7 (Sumberdaya/Proyeksinya/RAB) — lihat
    // KOMPONEN_LAMPIRAN_TAMBAHAN di bawah, bukan komponen lampiran murni.
    const KOMPONEN_LAMPIRAN = [
        14 => 'lampiran_rencana_aksi',
    ];

    // Komponen isian biasa (uraian+link) yang JUGA butuh 1 lampiran tambahan
    // menempel di kartu yang sama — bukan komponen lampiran murni seperti di atas.
    const KOMPONEN_LAMPIRAN_TAMBAHAN = [
        7 => 'lampiran_rab',
    ];

    private function isKomponenLampiran($komponenId)
    {
        return array_key_exists($komponenId, self::KOMPONEN_LAMPIRAN);
    }

    public function dashboard()
    {
        $peserta = Auth::guard('peserta')->user();
        $daftarPengajuan = Pengajuan::where('peserta_id', $peserta->id)->get();

        $catatanPengembalian = [];
        foreach ($daftarPengajuan as $item) {
            if (in_array($item->status, ['perlu_perbaikan', 'ditolak'])) {
                $riwayatTerakhir = RiwayatStatus::where('pengajuan_id', $item->id)
                    ->where('status', $item->status)
                    ->orderBy('id', 'desc')
                    ->first();

                if ($riwayatTerakhir) {
                    $catatanPengembalian[$item->id] = $riwayatTerakhir->catatan_panitia;
                }
            }
        }

        $sudahLewatDeadline = \App\Models\Pengaturan::sudahLewatDeadline();

        return view('peserta.pengajuan.dashboard', compact('daftarPengajuan', 'catatanPengembalian', 'sudahLewatDeadline'));
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
            'deskripsi' => 'required|string|max:2000',
            'jenis_inovasi' => 'required|in:digital,non_digital',
            'kategori_id' => 'required|exists:kategori,id',
            'unit_kerja_id' => 'required|exists:unit_kerja,id',
            'tahun_implementasi' => 'required|integer|min:2020|max:2030',
        ]);

        if (!$pengajuanId && \App\Models\Pengaturan::sudahLewatDeadline()) {
            return back()->withErrors([
                'umum' => 'Sudah lewat deadline pengajuan. Tidak bisa membuat pengajuan baru lagi.',
            ])->withInput();
        }

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
                'deskripsi' => $validated['deskripsi'],
                'jenis_inovasi' => $validated['jenis_inovasi'],
                'tahun_implementasi' => $validated['tahun_implementasi'],
                'bentuk_inovasi' => 'belum_dipilih',
                'status' => 'draft',
            ]);
        }

        return redirect()->route('peserta.pengajuan.step2', $pengajuan->id);
    }

    public function hapus($pengajuanId)
    {
        $peserta = Auth::guard('peserta')->user();
        $pengajuan = Pengajuan::where('id', $pengajuanId)
            ->where('peserta_id', $peserta->id)
            ->firstOrFail();

        if ($pengajuan->status !== 'draft') {
            return back()->withErrors([
                'umum' => 'Hanya pengajuan berstatus draft yang bisa dihapus. Pengajuan ini statusnya: ' . $pengajuan->status . '.',
            ]);
        }

        $pengajuan->anggotaKelompok()->delete();
        $pengajuan->dokumen()->delete();
        $pengajuan->isianProposal()->delete();
        $pengajuan->delete();

        return redirect()->route('peserta.dashboard')->with('sukses', 'Pengajuan draft berhasil dihapus.');
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
        $komponenIsian = $komponenList->reject(fn ($k) => $this->isKomponenLampiran($k->id));
        $komponenLampiran = $komponenList->filter(fn ($k) => $this->isKomponenLampiran($k->id));

        foreach ($komponenIsian as $komponen) {
            IsianProposal::firstOrCreate(
                ['pengajuan_id' => $pengajuan->id, 'komponen_id' => $komponen->id],
                ['uraian' => null]
            );
        }
        $isianTersimpan = IsianProposal::where('pengajuan_id', $pengajuan->id)
            ->with('links')
            ->get()
            ->keyBy('komponen_id');

        return view('peserta.pengajuan.step4', compact('pengajuan', 'dokumenTersimpan', 'komponenIsian', 'komponenLampiran', 'isianTersimpan'));
    }

    public function step4Store(Request $request, $pengajuanId)
    {
        $peserta = Auth::guard('peserta')->user();
        $pengajuan = Pengajuan::where('id', $pengajuanId)
            ->where('peserta_id', $peserta->id)
            ->firstOrFail();

        $rules = [
            'surat_identitas' => 'nullable|url:http,https|max:2048',
            'video_link' => 'required|url:http,https|max:2048',
            'uraian' => 'array',
            'link_judul' => 'array',
            'link_url' => 'array',
            'link_judul.*.*' => 'nullable|string|max:255',
            'link_url.*.*' => 'nullable|string|max:2048',
        ];

        $rules['lampiran_rab'] = 'nullable|url:http,https|max:2048';

        if ($pengajuan->bentuk_inovasi === 'eksisting') {
            $rules['surat_implementasi'] = 'nullable|url:http,https|max:2048';
        } else {
            $rules['surat_komitmen'] = 'nullable|url:http,https|max:2048';
            $rules['lampiran_rencana_aksi'] = 'nullable|url:http,https|max:2048';
        }

        $pesanValidasi = [
            'video_link.url' => 'Tautan video harus berupa alamat lengkap yang diawali http:// atau https://.',
        ];
        $namaAtribut = [
            'video_link' => 'tautan video',
            'link_url.*.*' => 'alamat tautan bukti dukung',
            'link_judul.*.*' => 'judul tautan',
        ];

        $labelTautan = [
            'surat_identitas' => 'Tautan surat pernyataan identitas inovator',
            'surat_implementasi' => 'Tautan surat pernyataan implementasi inovasi',
            'surat_komitmen' => 'Tautan surat pernyataan komitmen implementasi inovasi',
            'lampiran_rab' => 'Tautan dokumen RAB',
            'lampiran_rencana_aksi' => 'Tautan lampiran rencana aksi',
        ];
        foreach ($labelTautan as $kunci => $label) {
            $pesanValidasi["{$kunci}.url"] = "{$label} harus berupa alamat lengkap yang diawali http:// atau https://.";
            $pesanValidasi["{$kunci}.max"] = "{$label} terlalu panjang (maksimal 2048 karakter).";
            $namaAtribut[$kunci] = strtolower($label);
        }

        $validated = $request->validate($rules, $pesanValidasi, $namaAtribut);

        // Cek batas jumlah kata SEBELUM menyimpan apa pun, supaya tidak ada tulisan tersimpan
        // sebagian kalau ternyata melebihi batas (video_link/dokumen/isian jadi konsisten sama-sama gagal atau sama-sama tersimpan).
        $uraianInput = $request->input('uraian', []);

        $komponenLimits = KomponenPenilaian::pluck('jumlah_kata_maksimal', 'id');
        $komponenNama = KomponenPenilaian::pluck('nama', 'id');

        $pesanKata = [];
        foreach ($uraianInput as $komponenId => $uraian) {
            $limit = $komponenLimits[$komponenId] ?? null;
            if ($limit === null || trim((string) $uraian) === '') {
                continue;
            }
            $jumlahKata = count(preg_split('/\s+/', trim($uraian)));
            if ($jumlahKata > $limit) {
                $nama = $komponenNama[$komponenId] ?? "Komponen #{$komponenId}";
                $pesanKata[] = "{$nama}: {$jumlahKata} kata (maksimal {$limit} kata).";
            }
        }

        if (!empty($pesanKata)) {
            return back()->withErrors(['kata' => $pesanKata])->withInput();
        }

        // Periksa setiap tautan bukti dukung (alamat kosong atau bukan http/https): tolak sebelum menyimpan apa pun.
        $pesanTautan = [];
        foreach ($request->input('link_judul', []) as $komponenId => $judulArr) {
            $urlArr = $request->input("link_url.$komponenId", []);
            foreach ((array) $judulArr as $i => $judul) {
                $alamat = trim((string) ($urlArr[$i] ?? ''));
                $nama = $komponenNama[$komponenId] ?? "Komponen #{$komponenId}";
                $label = trim((string) $judul) !== '' ? "tautan \"{$judul}\"" : 'tautan';

                if (trim((string) $judul) !== '' && $alamat === '') {
                    $pesanTautan[] = "{$nama}: {$label} belum diisi alamatnya.";
                } elseif ($alamat !== '' && Validator::make(['alamat' => $alamat], ['alamat' => 'url:http,https'])->fails()) {
                    $pesanTautan[] = "{$nama}: {$label} harus berupa alamat lengkap yang diawali http:// atau https://.";
                }
            }
        }

        if (!empty($pesanTautan)) {
            return back()->withErrors(['tautan' => $pesanTautan])->withInput();
        }

        $pengajuan->dokumen()->updateOrCreate(
            ['jenis_dokumen' => 'video_link'],
            ['file_path' => $validated['video_link'], 'uploaded_at' => now()]
        );

        // Semua dokumen sekarang berupa tautan (bukan unggah berkas) agar ruang penyimpanan server hemat.
        $jenisTautanList = ['surat_identitas', 'lampiran_rab'];
        if ($pengajuan->bentuk_inovasi === 'eksisting') {
            $jenisTautanList[] = 'surat_implementasi';
        } else {
            $jenisTautanList[] = 'surat_komitmen';
            $jenisTautanList[] = 'lampiran_rencana_aksi';
        }

        foreach ($jenisTautanList as $jenis) {
            $alamat = trim((string) ($validated[$jenis] ?? ''));

            // Kolom dikosongkan: biarkan isi lama (kalau ada), jangan dihapus.
            if ($alamat === '') {
                continue;
            }

            $pengajuan->dokumen()->updateOrCreate(
                ['jenis_dokumen' => $jenis],
                ['nama_asli' => null, 'file_path' => $alamat, 'uploaded_at' => now()]
            );
        }

        foreach ($uraianInput as $komponenId => $uraian) {
            $isian = IsianProposal::updateOrCreate(
                ['pengajuan_id' => $pengajuan->id, 'komponen_id' => $komponenId],
                ['uraian' => $uraian]
            );

            // Hapus link lama lalu buat ulang dari yang dikirim — cara paling aman
            // untuk menangani tambah/hapus baris link yang dinamis dari form.
            $isian->links()->delete();
            $judulArr = $request->input("link_judul.$komponenId", []);
            $urlArr = $request->input("link_url.$komponenId", []);
            foreach ($judulArr as $i => $judul) {
                $url = $urlArr[$i] ?? null;
                if (trim((string) $judul) === '' && trim((string) $url) === '') {
                    continue;
                }
                $isian->links()->create([
                    'judul' => trim((string) $judul) !== '' ? $judul : 'Bukti Dukung',
                    'link' => $url,
                ]);
            }
        }

        return redirect()->route('peserta.pengajuan.step5', $pengajuan->id);
    }

    private function daftarDokumenWajib($pengajuan)
    {
        $wajib = ['surat_identitas', 'lampiran_rab'];
        $wajib[] = $pengajuan->bentuk_inovasi === 'eksisting' ? 'surat_implementasi' : 'surat_komitmen';
        $wajib[] = 'video_link';
        if ($pengajuan->bentuk_inovasi !== 'eksisting') {
            $wajib[] = 'lampiran_rencana_aksi';
        }
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
        $isianTersimpan = IsianProposal::where('pengajuan_id', $pengajuan->id)->with('links')->get()->keyBy('komponen_id');
        $isianBelumLengkap = [];
        foreach ($komponenList as $komponen) {
            if ($this->isKomponenLampiran($komponen->id)) {
                continue;
            }
            $isian = $isianTersimpan[$komponen->id] ?? null;
            if (!$isian || empty($isian->uraian) || $isian->links->isEmpty()) {
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
        $isianTersimpan = IsianProposal::where('pengajuan_id', $pengajuan->id)->with('links')->get()->keyBy('komponen_id');
        foreach ($komponenList as $komponen) {
            if ($this->isKomponenLampiran($komponen->id)) {
                continue;
            }
            $isian = $isianTersimpan[$komponen->id] ?? null;
            if (!$isian || empty($isian->uraian) || $isian->links->isEmpty()) {
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