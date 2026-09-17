<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengajuan - Langkah 4 - TERANG NONA</title>
</head>
<body>
    <h1>Pengajuan Baru — Langkah 4/5: Dokumen & Isian Proposal</h1>
    <p>{{ $pengajuan->nama_inovasi }} ({{ $pengajuan->akronim }}) — Bentuk: {{ $pengajuan->bentuk_inovasi }}</p>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('peserta.pengajuan.step4.submit', $pengajuan->id) }}" enctype="multipart/form-data">
        @csrf

        <h2>Bagian A — Dokumen Administratif</h2>

        <div>
            <label>Surat Pernyataan Identitas Inovator (PDF)</label><br>
            @if (isset($dokumenTersimpan['surat_identitas']))
                <p>Sudah diupload: {{ $dokumenTersimpan['surat_identitas']->nama_asli }}
                    <a href="{{ asset('storage/' . $dokumenTersimpan['surat_identitas']->file_path) }}" target="_blank">Lihat</a>
                </p>
            @endif
            <input type="file" name="surat_identitas" accept="application/pdf">
        </div>
        <br>

        @if ($pengajuan->bentuk_inovasi === 'eksisting')
            <div>
                <label>Surat Pernyataan Implementasi Inovasi (PDF)</label><br>
                @if (isset($dokumenTersimpan['surat_implementasi']))
                    <p>Sudah diupload: {{ $dokumenTersimpan['surat_implementasi']->nama_asli }}
                        <a href="{{ asset('storage/' . $dokumenTersimpan['surat_implementasi']->file_path) }}" target="_blank">Lihat</a>
                    </p>
                @endif
                <input type="file" name="surat_implementasi" accept="application/pdf">
            </div>
        @else
            <div>
                <label>Surat Pernyataan Komitmen Implementasi Inovasi (PDF)</label><br>
                @if (isset($dokumenTersimpan['surat_komitmen']))
                    <p>Sudah diupload: {{ $dokumenTersimpan['surat_komitmen']->nama_asli }}
                        <a href="{{ asset('storage/' . $dokumenTersimpan['surat_komitmen']->file_path) }}" target="_blank">Lihat</a>
                    </p>
                @endif
                <input type="file" name="surat_komitmen" accept="application/pdf">
            </div>
        @endif
        <br>

        <div>
            <label>Link Video Dampak Inovasi (YouTube/Drive/dll)</label><br>
            <input type="text" name="video_link"
                value="{{ isset($dokumenTersimpan['video_link']) ? $dokumenTersimpan['video_link']->file_path : old('video_link') }}"
                placeholder="https://..." required>
        </div>

        <hr>

        <h2>Bagian B — Isian Proposal ({{ count($komponenIsian) }} Komponen)</h2>
        <p><em>Isi uraian jawaban dan link bukti dukung (link Drive/dokumen pendukung) untuk setiap komponen di bawah. Keduanya wajib diisi.</em></p>

        @foreach ($komponenIsian as $komponen)
            @php $isianRow = $isianTersimpan[$komponen->id] ?? null; @endphp
            <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
                <strong>{{ $komponen->nama }}</strong> (Bobot {{ $komponen->bobot }}%)<br><br>

                <label>Uraian/Isian Inovasi
                    @if ($komponen->jumlah_kata_maksimal)
                        <span style="color: #666;">(Maksimal {{ $komponen->jumlah_kata_maksimal }} kata)</span>
                    @endif
                </label><br>
                <textarea name="uraian[{{ $komponen->id }}]" rows="4" cols="70">{{ old("uraian.{$komponen->id}", $isianRow->uraian ?? '') }}</textarea>
                <br><br>

                <label>Link/Tautan Bukti Dukung</label><br>
                <input type="text" name="link_bukti_dukung[{{ $komponen->id }}]"
                    value="{{ old("link_bukti_dukung.{$komponen->id}", $isianRow->link_bukti_dukung ?? '') }}"
                    placeholder="https://..." style="width: 400px;">
            </div>
        @endforeach

        @if (count($komponenLampiran) > 0)
            <hr>
            <h2>Bagian C — Lampiran Rencana Aksi & Rencana Anggaran</h2>
            <p><em>Untuk 2 komponen ini, isian berupa lampiran PDF (bukan uraian teks), sesuai form resmi.</em></p>

            @foreach ($komponenLampiran as $komponen)
                @php
                    $jenisDok = \App\Http\Controllers\Peserta\PengajuanController::KOMPONEN_LAMPIRAN[$komponen->id];
                    $dokTersimpan = $dokumenTersimpan[$jenisDok] ?? null;
                @endphp
                <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
                    <strong>{{ $komponen->nama }}</strong> (Bobot {{ $komponen->bobot }}%)<br><br>
                    @if ($dokTersimpan)
                        <p>Sudah diupload: {{ $dokTersimpan->nama_asli }}
                            <a href="{{ asset('storage/' . $dokTersimpan->file_path) }}" target="_blank">Lihat</a>
                        </p>
                    @endif
                    <label>Upload Lampiran (PDF)</label><br>
                    <input type="file" name="{{ $jenisDok }}" accept="application/pdf">
                </div>
            @endforeach
        @endif

        <br>
        <button type="submit">Simpan & Lanjut ke Langkah 5</button>
    </form>
    <script src="{{ asset('js/prevent-double-submit.js') }}"></script>
</body>
</html>