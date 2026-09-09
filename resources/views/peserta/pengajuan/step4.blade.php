<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengajuan Baru - Langkah 4 - TERANG NONA</title>
</head>
<body>
    <h1>Pengajuan Baru — Langkah 4/5: Upload Dokumen</h1>
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

        <div>
            <label>Proposal (PDF)</label><br>
            @if (isset($dokumenTersimpan['proposal']))
                <p>Sudah diupload: {{ $dokumenTersimpan['proposal']->nama_asli }}
                    <a href="{{ asset('storage/' . $dokumenTersimpan['proposal']->file_path) }}" target="_blank">Lihat</a>
                </p>
            @endif
            <input type="file" name="proposal" accept="application/pdf">
        </div>
        <br>

        <div>
            <label>Bukti Dukung (PDF)</label><br>
            @if (isset($dokumenTersimpan['bukti_dukung']))
                <p>Sudah diupload: {{ $dokumenTersimpan['bukti_dukung']->nama_asli }}
                    <a href="{{ asset('storage/' . $dokumenTersimpan['bukti_dukung']->file_path) }}" target="_blank">Lihat</a>
                </p>
            @endif
            <input type="file" name="bukti_dukung" accept="application/pdf">
        </div>
        <br>

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
        <br>

        <button type="submit">Simpan & Lanjut ke Langkah 5</button>
    </form>
</body>
</html>