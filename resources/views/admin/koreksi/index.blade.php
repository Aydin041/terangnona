<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Permintaan Koreksi Nilai - Admin - TERANG NONA</title>
</head>
<body>
    <h1>Permintaan Buka-Kunci Nilai</h1>

    <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>

    @if (session('sukses'))
        <p style="color: green;">{{ session('sukses') }}</p>
    @endif

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <hr>

    @if ($daftarPermintaan->isEmpty())
        <p>Belum ada permintaan koreksi.</p>
    @else
        <ul>
            @foreach ($daftarPermintaan as $item)
                <li style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
                    <strong>{{ $item->juri->nama }}</strong> → {{ $item->pengajuan->nama_inovasi }} ({{ $item->pengajuan->akronim }})<br>
                    Tahap: {{ $item->tahap }}<br>
                    @if ($item->tahap === 'proposal')
                        Komponen: {{ $item->komponen->nama ?? '-' }}<br>
                    @else
                        Aspek: {{ $item->aspek }}<br>
                    @endif
                    Alasan: {{ $item->alasan }}<br>
                    Status: <strong>{{ $item->status_persetujuan }}</strong>

                    @if ($item->status_persetujuan === 'menunggu')
                        <br><br>
                        <form method="POST" action="{{ route('admin.koreksi.setujui', $item->id) }}" style="display: inline;">
                            @csrf
                            <button type="submit">Setujui</button>
                        </form>
                        <form method="POST" action="{{ route('admin.koreksi.tolak', $item->id) }}" style="display: inline;">
                            @csrf
                            <button type="submit">Tolak</button>
                        </form>
                    @endif
                </li>
            @endforeach
        </ul>
    @endif
</body>
</html>