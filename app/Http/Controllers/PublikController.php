<?php

namespace App\Http\Controllers;

use App\Services\JadwalPublik;

class PublikController extends Controller
{
    public function beranda()
    {
        return view('publik.beranda', JadwalPublik::data());
    }

    public function tentang()
    {
        return view('publik.tentang', JadwalPublik::data());
    }

    public function jadwal()
    {
        return view('publik.jadwal', JadwalPublik::data());
    }

    public function unduhan()
    {
        $data = JadwalPublik::data();
        $folder = config('unduhan.folder', 'unduhan');

        $kelompok = [];
        foreach (config('unduhan.kelompok', []) as $namaKelompok => $daftarBerkas) {
            foreach ($daftarBerkas as $item) {
                $jalur = public_path($folder . '/' . $item['berkas']);
                $ada = is_file($jalur);
                $ekstensi = strtolower(pathinfo($item['berkas'], PATHINFO_EXTENSION));

                $ukuran = null;
                if ($ada) {
                    $byte = filesize($jalur);
                    $ukuran = $byte >= 1024 * 1024
                        ? number_format($byte / 1024 / 1024, 1, ',', '.') . ' MB'
                        : number_format(max($byte / 1024, 1), 0, ',', '.') . ' KB';
                }

                $judul = str_replace('{tahun}', (string) $data['tahunKompetisi'], $item['judul']);

                // Nama berkas saat diunduh: memakai 'nama_unduhan' dari config kalau ada,
                // kalau tidak dibuat dari judul (tanda / dan \\ diganti -), lalu ditambah ekstensi.
                $namaUnduhan = $item['nama_unduhan']
                    ?? trim(str_replace(['/', '\\'], '-', $judul)) . '.' . $ekstensi;

                $kelompok[$namaKelompok][] = [
                    'judul' => $judul,
                    'nama_unduhan' => $namaUnduhan,
                    'deskripsi' => $item['deskripsi'],
                    'jenis' => $ekstensi === 'pdf' ? 'pdf' : 'docx',
                    'label_jenis' => $ekstensi === 'pdf' ? 'PDF' : 'DOCX',
                    'ada' => $ada,
                    'ukuran' => $ukuran,
                    'url' => $ada ? asset($folder . '/' . $item['berkas']) : null,
                ];
            }
        }

        return view('publik.unduhan', $data + ['kelompok' => $kelompok]);
    }
}