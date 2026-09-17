<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Pengajuan - Panitia - TERANG NONA</title>
</head>
<body>
    <h1>Detail Pengajuan</h1>
    <p><a href="{{ route('panitia.pengajuan.index') }}">← Kembali ke daftar</a></p>

    @if ($errors->any())
        <div style="color: red; border: 1px solid red; padding: 10px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h3>Profil Inovasi</h3>
    <p><strong>Nama Inovasi:</strong> {{ $pengajuan->nama_inovasi }} ({{ $pengajuan->akronim }})</p>
    <p><strong>Kategori:</strong> {{ $pengajuan->kategori->nama }}</p>
    <p><strong>Bentuk Inovasi:</strong> {{ $pengajuan->bentuk_inovasi }}</p>
    <p><strong>Status Saat Ini:</strong> {{ $pengajuan->status }}</p>
    <p><strong>Peserta:</strong> {{ $pengajuan->peserta->nama }} ({{ $pengajuan->peserta->email }})</p>

    <h3>Ketua & Anggota</h3>
    <ul>
        @foreach ($pengajuan->anggotaKelompok as $anggota)
            <li>
                {{ $anggota->nama }} ({{ $anggota->kontak }})
                @if ($anggota->adalah_ketua) <strong>— Ketua</strong> @endif
            </li>
        @endforeach
    </ul>

    @if (count($peringatanDuplikasi) > 0)
        <div style="background: yellow; padding: 10px;">
            <strong>⚠ Peringatan: Ditemukan kemiripan nama dengan pengajuan lain (cek manual untuk BR01):</strong>
            <ul>
                @foreach ($peringatanDuplikasi as $pengajuanId => $info)
                    <li>{{ $info }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h3>Dokumen</h3>
    <ul>
        @foreach ($pengajuan->dokumen as $dok)
            <li>
                {{ $dok->jenis_dokumen }}:
                @if ($dok->jenis_dokumen === 'video_link')
                    <a href="{{ $dok->file_path }}" target="_blank">{{ $dok->file_path }}</a>
                @else
                    {{ $dok->nama_asli }}
                    <a href="{{ asset('storage/' . $dok->file_path) }}" target="_blank">Lihat</a>
                @endif
            </li>
        @endforeach
    </ul>

    <hr>

    @if ($pengajuan->status === 'menunggu_pemeriksaan')
        <h3>Aksi</h3>

        <form method="POST" action="{{ route('panitia.pengajuan.setujui', $pengajuan->id) }}" style="display:inline;">
            @csrf
            <button type="submit">Setujui</button>
        </form>

        <form method="POST" action="{{ route('panitia.pengajuan.kembalikan', $pengajuan->id) }}" style="margin-top: 10px;">
            @csrf
            <label>Alasan pengembalian (wajib diisi kalau mau kembalikan)</label><br>
            <textarea name="catatan_panitia" rows="3" cols="50">{{ old('catatan_panitia') }}</textarea><br>
            <button type="submit">Kembalikan ke Peserta</button>
        </form>
    @else
        <p><em>Pengajuan ini sudah diproses (status: {{ $pengajuan->status }}), tidak ada aksi tersedia.</em></p>
    @endif
    <script src="{{ asset('js/prevent-double-submit.js') }}"></script>
</body>
</html>