<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengajuan Baru - Langkah 5 - TERANG NONA</title>
</head>
<body>
    <h1>Pengajuan Baru — Langkah 5/5: Review & Submit</h1>

    @if ($errors->any())
        <div style="color: red;">
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
    <p><strong>Tahun Implementasi:</strong> {{ $pengajuan->tahun_implementasi }}</p>

    <h3>Ketua & Anggota</h3>
    <ul>
        @foreach ($anggotaKelompok as $anggota)
            <li>
                {{ $anggota->nama }} ({{ $anggota->kontak }})
                @if ($anggota->adalah_ketua) <strong>— Ketua</strong> @endif
            </li>
        @endforeach
    </ul>

    <h3>Dokumen</h3>
    @if (count($dokumenBelumLengkap) > 0)
        <div style="color: red;">
            <p><strong>Dokumen berikut belum lengkap:</strong></p>
            <ul>
                @foreach ($dokumenBelumLengkap as $jenis)
                    <li>{{ $jenis }}</li>
                @endforeach
            </ul>
            <p><a href="{{ route('peserta.pengajuan.step4', $pengajuan->id) }}">Kembali ke Langkah 4 untuk melengkapi</a></p>
        </div>
    @else
        <ul>
            @foreach ($dokumenTersimpan as $jenis => $dok)
                <li>
                    {{ $jenis }}:
                    @if ($jenis === 'video_link')
                        <a href="{{ $dok->file_path }}" target="_blank">{{ $dok->file_path }}</a>
                    @else
                        {{ $dok->nama_asli }}
                        <a href="{{ asset('storage/' . $dok->file_path) }}" target="_blank">Lihat</a>
                    @endif
                </li>
            @endforeach
        </ul>
    @endif

    <hr>

    @if (count($dokumenBelumLengkap) === 0)
        <form method="POST" action="{{ route('peserta.pengajuan.step5.submit', $pengajuan->id) }}">
            @csrf
            <button type="submit">Submit Pengajuan</button>
        </form>
    @else
        <p><em>Tombol submit muncul setelah semua dokumen wajib lengkap.</em></p>
    @endif
</body>
</html>