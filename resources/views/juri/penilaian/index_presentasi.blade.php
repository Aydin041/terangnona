<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Penilaian Presentasi - Juri - TERANG NONA</title>
</head>
<body>
    <h1>Penilaian Presentasi (Lolos 5 Besar)</h1>
    <p style="background: #eee; padding: 8px;">Login sebagai Juri: <strong>{{ Auth::guard('juri')->user()->nama }}</strong> ({{ Auth::guard('juri')->user()->email }})</p>

    <p><a href="{{ route('juri.penilaian.index') }}">← Kembali ke menu penilaian</a></p>

    @if (session('sukses'))
        <p style="color: green;">{{ session('sukses') }}</p>
    @endif

    <hr>

    @if ($daftarPengajuan->isEmpty())
        <p>Belum ada pengajuan yang lolos 5 besar untuk dinilai presentasinya.</p>
    @else
        @php
            $kelompokStatus = [
                'belum_dinilai' => ['label' => 'Belum Dinilai', 'warna' => '#d9534f'],
                'draft' => ['label' => 'Draft (belum disubmit)', 'warna' => '#f0ad4e'],
                'submitted' => ['label' => 'Sudah Submit', 'warna' => '#5cb85c'],
            ];
        @endphp

        @foreach ($kelompokStatus as $kunciStatus => $info)
            @php
                $itemDiKelompok = $daftarPengajuan->filter(fn ($item) => $statusPenilaian[$item->id] === $kunciStatus);
            @endphp

            <h3 style="color: {{ $info['warna'] }};">{{ $info['label'] }} ({{ count($itemDiKelompok) }})</h3>

            @if ($itemDiKelompok->isEmpty())
                <p><em>Tidak ada.</em></p>
            @else
                <ul>
                    @foreach ($itemDiKelompok as $item)
                        <li>
                            <strong>{{ $item->nama_inovasi }} ({{ $item->akronim }})</strong><br>
                            Kategori: {{ $item->kategori->nama }} | Bentuk: {{ $item->bentuk_inovasi }}<br>
                            <a href="{{ route('juri.penilaian.presentasi', $item->id) }}">Nilai Presentasi</a>
                        </li>
                        <hr>
                    @endforeach
                </ul>
            @endif
        @endforeach
    @endif
</body>
</html>