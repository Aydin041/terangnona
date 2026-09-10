<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Penilaian Proposal - Juri - TERANG NONA</title>
</head>
<body>
    <h1>Penilaian Proposal</h1>

    <form method="POST" action="{{ route('juri.logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>

    @if (session('sukses'))
        <p style="color: green;">{{ session('sukses') }}</p>
    @endif

    <hr>

    @if ($daftarPengajuan->isEmpty())
        <p>Belum ada pengajuan yang disetujui Panitia untuk dinilai.</p>
    @else
        <ul>
            @foreach ($daftarPengajuan as $item)
                <li>
                    <strong>{{ $item->nama_inovasi }} ({{ $item->akronim }})</strong><br>
                    Kategori: {{ $item->kategori->nama }} | Bentuk: {{ $item->bentuk_inovasi }}<br>
                    Status penilaian Anda: {{ $statusPenilaian[$item->id] }}<br>
                    <a href="{{ route('juri.penilaian.proposal', $item->id) }}">Nilai Proposal</a>
                </li>
                <hr>
            @endforeach
        </ul>
    @endif
</body>
</html>