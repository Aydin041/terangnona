<?php

namespace App\Http\Controllers\Panitia;

use App\Http\Controllers\Controller;
use App\Models\AnggotaKelompok;
use App\Models\Pengajuan;
use App\Models\RiwayatStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');

        $query = Pengajuan::with('peserta', 'kategori');

        if ($status) {
            $query->where('status', $status);
        }

        $daftarPengajuan = $query->orderBy('created_at', 'desc')->get();

        return view('panitia.pengajuan.index', compact('daftarPengajuan', 'status'));
    }

    public function detail($id)
    {
        $pengajuan = Pengajuan::with('peserta', 'kategori', 'anggotaKelompok', 'dokumen')
            ->findOrFail($id);

        // Cari peringatan kemiripan nama (BR01) — bukan blocking, cuma informasi utk Panitia
        $namaAnggotaIni = $pengajuan->anggotaKelompok->pluck('nama')->map(function ($nama) {
            return strtolower(trim($nama));
        });

        $peringatanDuplikasi = [];
        $kandidatMirip = AnggotaKelompok::where('pengajuan_id', '!=', $pengajuan->id)
            ->get();

        foreach ($kandidatMirip as $kandidat) {
            $namaKandidat = strtolower(trim($kandidat->nama));
            if ($namaAnggotaIni->contains($namaKandidat)) {
                $pengajuanLain = Pengajuan::find($kandidat->pengajuan_id);
                if ($pengajuanLain) {
                    $peringatanDuplikasi[$pengajuanLain->id] = $pengajuanLain->nama_inovasi . ' (' . $kandidat->nama . ')';
                }
            }
        }

        return view('panitia.pengajuan.detail', compact('pengajuan', 'peringatanDuplikasi'));
    }

    public function setujui($id)
    {
        $panitia = Auth::guard('panitia')->user();
        $pengajuan = Pengajuan::findOrFail($id);

        if ($pengajuan->status !== 'menunggu_pemeriksaan') {
            return redirect()->route('panitia.pengajuan.detail', $pengajuan->id)
                ->withErrors(['umum' => 'Pengajuan ini sudah diproses sebelumnya (status saat ini: ' . $pengajuan->status . '), tidak bisa disetujui lagi.']);
        }

        $pengajuan->update(['status' => 'disetujui']);

        RiwayatStatus::create([
            'pengajuan_id' => $pengajuan->id,
            'status' => 'disetujui',
            'catatan_panitia' => null,
            'panitia_id' => $panitia->id,
            'changed_at' => now(),
        ]);

        return redirect()->route('panitia.pengajuan.index')->with('sukses', 'Pengajuan disetujui.');
    }

    public function kembalikan(Request $request, $id)
    {
        $validated = $request->validate([
            'catatan_panitia' => 'required|string|max:1000',
        ]);

        $panitia = Auth::guard('panitia')->user();
        $pengajuan = Pengajuan::findOrFail($id);

        if ($pengajuan->status !== 'menunggu_pemeriksaan') {
            return redirect()->route('panitia.pengajuan.detail', $pengajuan->id)
                ->withErrors(['umum' => 'Pengajuan ini sudah diproses sebelumnya (status saat ini: ' . $pengajuan->status . '), tidak bisa dikembalikan lagi.']);
        }

        $pengajuan->update(['status' => 'perlu_perbaikan']);

        RiwayatStatus::create([
            'pengajuan_id' => $pengajuan->id,
            'status' => 'perlu_perbaikan',
            'catatan_panitia' => $validated['catatan_panitia'],
            'panitia_id' => $panitia->id,
            'changed_at' => now(),
        ]);

        return redirect()->route('panitia.pengajuan.index')->with('sukses', 'Pengajuan dikembalikan ke peserta.');
    }

    public function tolak(Request $request, $id)
    {
        $validated = $request->validate([
            'catatan_panitia' => 'required|string|max:1000',
        ]);

        $panitia = Auth::guard('panitia')->user();
        $pengajuan = Pengajuan::findOrFail($id);

        if ($pengajuan->status !== 'menunggu_pemeriksaan') {
            return redirect()->route('panitia.pengajuan.detail', $pengajuan->id)
                ->withErrors(['umum' => 'Pengajuan ini sudah diproses sebelumnya (status saat ini: ' . $pengajuan->status . '), tidak bisa ditolak lagi.']);
        }

        $pengajuan->update(['status' => 'ditolak']);

        RiwayatStatus::create([
            'pengajuan_id' => $pengajuan->id,
            'status' => 'ditolak',
            'catatan_panitia' => $validated['catatan_panitia'],
            'panitia_id' => $panitia->id,
            'changed_at' => now(),
        ]);

        return redirect()->route('panitia.pengajuan.index')->with('sukses', 'Pengajuan ditolak.');
    }

    public function exportNilaiProposal()
    {
        $rows = \App\Models\NilaiKomponenProposal::with(['submission.pengajuan.kategori', 'submission.juri', 'komponen'])
            ->whereNotNull('nilai')
            ->get();

        $bentukLabel = [
            'eksisting' => 'Eksisting',
            'pengembangan' => 'Pengembangan',
            'rancangan' => 'Rancangan',
        ];

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $spreadsheet->removeSheetByIndex(0);

        foreach ($bentukLabel as $kunciBentuk => $label) {
            $rowsBentuk = $rows->filter(fn ($r) => $r->submission->pengajuan->bentuk_inovasi === $kunciBentuk)
                ->sortBy([
                    fn ($r) => $r->submission->pengajuan->nama_inovasi,
                    fn ($r) => $r->submission->juri->nama,
                ])
                ->groupBy(fn ($r) => $r->submission->pengajuan_id . '-' . $r->submission->juri_id);

            $this->tulisSheetNilaiProposal($spreadsheet, $label, $rowsBentuk);
        }

        return $this->unduhSpreadsheet($spreadsheet, 'nilai-proposal-terang-nona.xlsx');
    }

    private function tulisSheetNilaiProposal(\PhpOffice\PhpSpreadsheet\Spreadsheet $spreadsheet, string $judulSheet, $kelompokRows)
    {
        $sheet = $spreadsheet->createSheet();
        $sheet->setTitle($judulSheet);

        $header = ['Nama Inovasi', 'Akronim', 'Kategori', 'Nama Juri', 'Komponen', 'Bobot (%)', 'Nilai', 'Nilai Tertimbang', 'Komentar'];
        $sheet->fromArray($header, null, 'A1');
        $sheet->getStyle('A1:I1')->getFont()->setBold(true);
        $sheet->getStyle('A1:I1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('FEF3C7');

        $baris = 2;
        foreach ($kelompokRows as $kelompok) {
            $barisAwal = $baris;
            $pengajuan = $kelompok->first()->submission->pengajuan;
            $juri = $kelompok->first()->submission->juri;

            foreach ($kelompok as $row) {
                $sheet->fromArray([
                    $pengajuan->nama_inovasi,
                    $pengajuan->akronim,
                    $pengajuan->kategori->nama ?? '-',
                    $juri->nama,
                    $row->komponen->nama,
                    $row->komponen->bobot,
                    $row->nilai,
                    null, // diisi rumus di bawah
                    $row->komentar,
                ], null, "A{$baris}");
                $sheet->setCellValue("H{$baris}", "=F{$baris}/100*G{$baris}");
                $baris++;
            }

            $barisAkhir = $baris - 1;
            $sheet->setCellValue("G{$baris}", 'Total');
            $sheet->getStyle("G{$baris}")->getFont()->setBold(true);
            $sheet->setCellValue("H{$baris}", "=SUM(H{$barisAwal}:H{$barisAkhir})");
            $sheet->getStyle("H{$baris}")->getFont()->setBold(true);
            $baris++;
        }

        if ($baris === 2) {
            $sheet->setCellValue('A2', '(Belum ada nilai untuk kelompok ini)');
        }

        foreach (range('A', 'I') as $kolom) {
            $sheet->getColumnDimension($kolom)->setAutoSize(true);
        }
        $sheet->getStyle("A1:I" . ($baris - 1))->getBorders()->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    }

    public function exportNilaiPresentasi()
    {
        $labelAspek = \App\Http\Controllers\Juri\PenilaianController::ASPEK_PRESENTASI;

        $rows = \App\Models\NilaiAspekPresentasi::with(['submission.pengajuan.kategori', 'submission.juri'])
            ->whereNotNull('nilai')
            ->get();

        $bentukLabel = [
            'eksisting' => 'Eksisting',
            'pengembangan' => 'Pengembangan',
            'rancangan' => 'Rancangan',
        ];

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $spreadsheet->removeSheetByIndex(0);

        foreach ($bentukLabel as $kunciBentuk => $label) {
            $rowsBentuk = $rows->filter(fn ($r) => $r->submission->pengajuan->bentuk_inovasi === $kunciBentuk)
                ->sortBy([
                    fn ($r) => $r->submission->pengajuan->nama_inovasi,
                    fn ($r) => $r->submission->juri->nama,
                ])
                ->groupBy(fn ($r) => $r->submission->pengajuan_id . '-' . $r->submission->juri_id);

            $this->tulisSheetNilaiPresentasi($spreadsheet, $label, $rowsBentuk, $labelAspek);
        }

        return $this->unduhSpreadsheet($spreadsheet, 'nilai-presentasi-terang-nona.xlsx');
    }

    private function tulisSheetNilaiPresentasi(\PhpOffice\PhpSpreadsheet\Spreadsheet $spreadsheet, string $judulSheet, $kelompokRows, array $labelAspek)
    {
        $sheet = $spreadsheet->createSheet();
        $sheet->setTitle($judulSheet);

        $header = ['Nama Inovasi', 'Akronim', 'Kategori', 'Nama Juri', 'Aspek', 'Nilai', 'Catatan'];
        $sheet->fromArray($header, null, 'A1');
        $sheet->getStyle('A1:G1')->getFont()->setBold(true);
        $sheet->getStyle('A1:G1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('DBEAFE');

        $baris = 2;
        foreach ($kelompokRows as $kelompok) {
            $barisAwal = $baris;
            $pengajuan = $kelompok->first()->submission->pengajuan;
            $juri = $kelompok->first()->submission->juri;

            foreach ($kelompok as $row) {
                $sheet->fromArray([
                    $pengajuan->nama_inovasi,
                    $pengajuan->akronim,
                    $pengajuan->kategori->nama ?? '-',
                    $juri->nama,
                    $labelAspek[$row->aspek] ?? $row->aspek,
                    $row->nilai,
                    $row->catatan,
                ], null, "A{$baris}");
                $baris++;
            }

            $barisAkhir = $baris - 1;
            $sheet->setCellValue("E{$baris}", 'Rata-rata');
            $sheet->getStyle("E{$baris}")->getFont()->setBold(true);
            $sheet->setCellValue("F{$baris}", "=AVERAGE(F{$barisAwal}:F{$barisAkhir})");
            $sheet->getStyle("F{$baris}")->getFont()->setBold(true);
            $baris++;
        }

        if ($baris === 2) {
            $sheet->setCellValue('A2', '(Belum ada nilai untuk kelompok ini)');
        }

        foreach (range('A', 'G') as $kolom) {
            $sheet->getColumnDimension($kolom)->setAutoSize(true);
        }
        $sheet->getStyle("A1:G" . ($baris - 1))->getBorders()->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    }

    private function unduhSpreadsheet(\PhpOffice\PhpSpreadsheet\Spreadsheet $spreadsheet, string $namaFile)
    {
        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $namaFile, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
}