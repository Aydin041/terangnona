<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Pengajuan - Panitia - TERANG NONA</title>
</head>
<body>
    <h1>Daftar Pengajuan</h1>

    <form method="POST" action="{{ route('panitia.logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>

    @if (session('sukses'))
        <p style="color: green;">{{ session('sukses') }}</p>
    @endif

    <p>
        Filter:
        <a href="{{ route('panitia.pengajuan.index') }}">Semua</a> |
        <a href="{{ route('panitia.pengajuan.index', ['status' => 'menunggu_pemeriksaan']) }}">Menunggu Pemeriksaan</a> |
        <a href="{{ route('panitia.pengajuan.index', ['status' => 'disetujui']) }}">Disetujui</a> |
        <a href="{{ route('panitia.pengajuan.index', ['status' => 'perlu_perbaikan']) }}">Perlu Perbaikan</a>
    </p>

    <hr>

    @if ($daftarPengajuan->isEmpty())
        <p>Tidak ada pengajuan.</p>
    @else
        <ul>
            @foreach ($daftarPengajuan as $item)
                <li>
                    <strong>{{ $item->nama_inovasi }} ({{ $item->akronim }})</strong><br>
                    Peserta: {{ $item->peserta->nama }} | Kategori: {{ $item->kategori->nama }}<br>
                    Status: {{ $item->status }}<br>
                    <a href="{{ route('panitia.pengajuan.detail', $item->id) }}">Lihat Detail</a>
                </li>
                <hr>
            @endforeach
        </ul>
    @endif
</body>
</html>