<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Juri;
use App\Models\Pengaturan;
use App\Models\TahapJadwal;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    public function form()
    {
        $pengaturan = Pengaturan::ambil();
        $jumlahJuri = Juri::count();

        $petunjukSurvei = $this->petunjukSurvei();

        return view('admin.pengaturan.index', compact('pengaturan', 'jumlahJuri', 'petunjukSurvei'));
    }

    /**
     * Saran waktu survei, diambil dari jadwal kegiatan supaya tanggalnya selalu mengikuti jadwal.
     */
    private function petunjukSurvei(): string
    {
        $tahap = collect(TahapJadwal::semua())->keyBy('kunci');

        if (! isset($tahap['pengumuman'], $tahap['penghargaan'])) {
            return 'Kosongkan keduanya untuk menutup survei.';
        }

        $format = fn (string $tanggal) => Carbon::parse($tanggal)->locale('id')->translatedFormat('j F');

        return 'Saran: buka setelah Pengumuman Hasil (' . $format($tahap['pengumuman']['mulai'])
            . ') dan tutup setelah Penyerahan Penghargaan (' . $format($tahap['penghargaan']['selesai'])
            . '). Kosongkan keduanya untuk menutup survei.';
    }

    public function update(Request $request)
    {
        $jumlahJuri = max(1, Juri::count());

        $validated = $request->validate([
            'deadline_pengajuan' => 'nullable|date',
            'minimal_juri_submit' => ['required', 'integer', 'min:1', 'max:' . $jumlahJuri],
            'survei_dibuka_pada' => 'nullable|date|required_with:survei_ditutup_pada',
            'survei_ditutup_pada' => 'nullable|date|required_with:survei_dibuka_pada|after:survei_dibuka_pada',
        ], [
            'minimal_juri_submit.required' => 'Minimal juri wajib diisi.',
            'minimal_juri_submit.integer' => 'Minimal juri harus berupa angka bulat.',
            'minimal_juri_submit.min' => 'Minimal juri tidak boleh kurang dari 1.',
            'survei_dibuka_pada.required_with' => 'Isi kedua waktu survei, atau kosongkan keduanya.',
            'survei_dibuka_pada.date' => 'Waktu buka survei bukan tanggal yang valid.',
            'survei_ditutup_pada.required_with' => 'Isi kedua waktu survei, atau kosongkan keduanya.',
            'survei_ditutup_pada.date' => 'Waktu tutup survei bukan tanggal yang valid.',
            'survei_ditutup_pada.after' => 'Waktu tutup survei harus setelah waktu buka.',
            'minimal_juri_submit.max' => "Minimal juri tidak boleh lebih dari jumlah akun Juri yang ada ({$jumlahJuri}).",
        ]);

        $pengaturan = Pengaturan::ambil();
        $pengaturan->update([
            'deadline_pengajuan' => $validated['deadline_pengajuan'] ?? null,
            'minimal_juri_submit' => (int) $validated['minimal_juri_submit'],
            'survei_dibuka_pada' => $validated['survei_dibuka_pada'] ?? null,
            'survei_ditutup_pada' => $validated['survei_ditutup_pada'] ?? null,
        ]);

        return back()->with('sukses', 'Pengaturan berhasil disimpan.');
    }
}