<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use App\Models\SurveiJawaban;
use App\Models\SurveiPartisipasi;
use App\Services\SurveiService;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class SurveiController extends Controller
{
    public function form()
    {
        $peserta = Auth::guard('peserta')->user();
        $pengaturan = Pengaturan::ambil();

        return view('peserta.survei.index', [
            'layak' => $peserta->layakSurvei(),
            'sudahMengisi' => SurveiPartisipasi::where('peserta_id', $peserta->id)->exists(),
            'status' => Pengaturan::statusSurvei(),
            'dibuka' => $pengaturan->survei_dibuka_pada,
            'ditutup' => $pengaturan->survei_ditutup_pada,
            'aspekList' => SurveiService::ASPEK,
        ]);
    }

    public function kirim(Request $request)
    {
        $peserta = Auth::guard('peserta')->user();

        // Semua syarat diperiksa ulang di sini, tidak hanya di tampilan.
        if (! $peserta->layakSurvei() || Pengaturan::statusSurvei() !== 'dibuka') {
            return redirect()->route('peserta.survei.form');
        }

        $validated = $request->validate([
            'nilai' => ['required', 'integer', 'between:1,5'],
            'aspek' => ['required', 'array', 'min:1'],
            'aspek.*' => ['string', Rule::in(array_keys(SurveiService::ASPEK))],
            'saran' => ['required', 'string', 'max:2000'],
        ], [
            'nilai.required' => 'Pilih penilaian 1 sampai 5.',
            'nilai.between' => 'Penilaian harus antara 1 dan 5.',
            'aspek.required' => 'Pilih sedikitnya satu aspek yang perlu ditingkatkan.',
            'aspek.min' => 'Pilih sedikitnya satu aspek yang perlu ditingkatkan.',
            'aspek.*.in' => 'Ada aspek yang tidak dikenal.',
            'saran.required' => 'Saran dan masukan wajib diisi.',
            'saran.max' => 'Saran dan masukan terlalu panjang (maksimal :max karakter).',
        ]);

        // Urutan aspek disamakan dengan urutan di formulir, supaya urutan klik tidak ikut tersimpan.
        $aspek = array_values(array_intersect(array_keys(SurveiService::ASPEK), $validated['aspek']));

        try {
            DB::transaction(function () use ($peserta, $validated, $aspek) {
                // Baris ini unik per peserta: kiriman ganda (termasuk yang bersamaan) akan ditolak database.
                SurveiPartisipasi::create(['peserta_id' => $peserta->id]);

                // Jawaban disimpan tanpa peserta_id, tanpa waktu, dan tanpa hubungan ke baris di atas.
                SurveiJawaban::create([
                    'nilai' => (int) $validated['nilai'],
                    'aspek' => $aspek,
                    'saran' => trim($validated['saran']),
                ]);
            });
        } catch (UniqueConstraintViolationException $e) {
            return redirect()->route('peserta.survei.form');
        }

        return redirect()->route('peserta.survei.form')->with('sukses', 'Terima kasih, survei Anda sudah terkirim.');
    }
}