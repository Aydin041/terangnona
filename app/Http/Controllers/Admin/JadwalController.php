<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TahapJadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class JadwalController extends Controller
{
    public function index()
    {
        $tahap = TahapJadwal::urut();

        return view('admin.jadwal.index', compact('tahap'));
    }

    public function update(Request $request)
    {
        $tahap = TahapJadwal::urut();

        $aturan = [];
        $atribut = [];

        foreach ($tahap as $i => $t) {
            $nomor = $i + 1;

            $aturan["tahap.{$t->id}.nama"] = 'required|string|max:200';
            $aturan["tahap.{$t->id}.mulai"] = 'required|date';
            $aturan["tahap.{$t->id}.selesai"] = "required|date|after_or_equal:tahap.{$t->id}.mulai";
            $aturan["tahap.{$t->id}.sorot"] = 'nullable|string|max:60';

            $atribut["tahap.{$t->id}.nama"] = "Nama tahap {$nomor}";
            $atribut["tahap.{$t->id}.mulai"] = "Tanggal mulai tahap {$nomor}";
            $atribut["tahap.{$t->id}.selesai"] = "Tanggal selesai tahap {$nomor}";
            $atribut["tahap.{$t->id}.sorot"] = "Teks kartu tahap {$nomor}";
        }

        $validated = Validator::make($request->all(), $aturan, [
            'required' => ':attribute wajib diisi.',
            'date' => ':attribute bukan tanggal yang valid.',
            'max' => ':attribute terlalu panjang (maksimal :max karakter).',
            'after_or_equal' => ':attribute tidak boleh lebih awal dari tanggal mulainya.',
        ], $atribut)->validate();

        DB::transaction(function () use ($tahap, $validated) {
            foreach ($tahap as $t) {
                $isi = $validated['tahap'][$t->id];

                $t->update([
                    'nama' => $isi['nama'],
                    'mulai' => $isi['mulai'],
                    'selesai' => $isi['selesai'],
                    'sorot' => filled($isi['sorot'] ?? null) ? $isi['sorot'] : null,
                ]);
            }
        });

        return redirect()->route('admin.jadwal.index')->with('sukses', 'Jadwal berhasil disimpan.');
    }
}