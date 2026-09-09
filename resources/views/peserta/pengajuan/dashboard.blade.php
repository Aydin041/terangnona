<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Saya - TERANG NONA</title>
</head>
<body>
    <h1>Dashboard Saya</h1>

    <form method="POST" action="{{ route('peserta.logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>

    <hr>

    @if ($daftarPengajuan->isEmpty())
        <p>Belum ada pengajuan. Mulai pengajuan baru untuk mengikuti TERANG NONA 2026.</p>
    @else
        <ul>
            @foreach ($daftarPengajuan as $item)
                <li>
                    <strong>{{ $item->nama_inovasi }} ({{ $item->akronim }})</strong><br>
                    Status: {{ $item->status }}
                </li>
            @endforeach
        </ul>
    @endif

    <a href="{{ route('peserta.pengajuan.step1') }}">
        <button type="button">+ Buat Pengajuan Baru</button>
    </a>
</body>
</html>