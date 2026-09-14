<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Penilaian - Juri - TERANG NONA</title>
</head>
<body>
    <h1>Daftar Penilaian</h1>

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
                    Status penilaian proposal Anda: {{ $statusPenilaian[$item->id] }}<br>
                    <a href="{{ route('juri.penilaian.proposal', $item->id) }}">Nilai Proposal</a>

                    @if (in_array($item->id, $idLolos5Besar))
                        | <a href="{{ route('juri.penilaian.presentasi', $item->id) }}">
                            <strong style="color: green;">Nilai Presentasi (Lolos 5 Besar)</strong>
                        </a>
                    @endif
                </li>
                <hr>
            @endforeach
        </ul>
    @endif
</body>
</html>