<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ranking - Panitia - TERANG NONA</title>
</head>
<body>
    <h1>Ranking Peserta</h1>
    <p><a href="{{ route('panitia.pengajuan.index') }}">← Kembali ke Daftar Pengajuan</a></p>

    <p><em>Catatan: nilai baru muncul di sini kalau minimal 2 dari 3 Juri sudah submit penilaian proposal untuk pengajuan tersebut. Pengajuan yang belum cukup dinilai tidak akan tampil.</em></p>

    <h2>Kelompok: Inovasi Eksisting</h2>
    @if (empty($ranking['eksisting']))
        <p>Belum ada nilai final untuk kelompok ini.</p>
    @else
        <ol>
            @foreach ($ranking['eksisting'] as $item)
                <li>
                    {{ $item['pengajuan']->nama_inovasi }} ({{ $item['pengajuan']->akronim }})
                    — Nilai: {{ $item['nilai_proposal'] }}
                    @if (in_array($item['pengajuan']->id, $idLolos5Besar))
                        <strong style="color: green;"> [LOLOS 5 BESAR]</strong>
                    @endif
                </li>
            @endforeach
        </ol>
    @endif

    <h2>Kelompok: Pengembangan & Rancangan Inovasi</h2>
    @if (empty($ranking['pengembangan_rancangan']))
        <p>Belum ada nilai final untuk kelompok ini.</p>
    @else
        <ol>
            @foreach ($ranking['pengembangan_rancangan'] as $item)
                <li>
                    {{ $item['pengajuan']->nama_inovasi }} ({{ $item['pengajuan']->akronim }})
                    — Nilai: {{ $item['nilai_proposal'] }}
                    @if (in_array($item['pengajuan']->id, $idLolos5Besar))
                        <strong style="color: green;"> [LOLOS 5 BESAR]</strong>
                    @endif
                </li>
            @endforeach
        </ol>
    @endif
</body>
</html>