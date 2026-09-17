<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ranking - Panitia - TERANG NONA</title>
</head>
<body>
    <h1>Ranking Peserta</h1>
    <p><a href="{{ route('panitia.pengajuan.index') }}">← Kembali ke Daftar Pengajuan</a></p>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('sukses'))
        <p style="color: green;">{{ session('sukses') }}</p>
    @endif


    <h2>Tahap 1 — Ranking Proposal (5 Besar)</h2>
    <p><em>Minimal 2 dari 3 Juri sudah submit penilaian proposal.</em></p>

    <h3>Kelompok: Inovasi Eksisting</h3>
    @if (empty($ranking['eksisting']))
        <p>Belum ada nilai final.</p>
    @else
        <ol>
            @foreach ($ranking['eksisting'] as $item)
                <li>
                    {{ $item['pengajuan']->nama_inovasi }} ({{ $item['pengajuan']->akronim }})
                    — Nilai Proposal: {{ $item['nilai_proposal'] }}
                    @if (in_array($item['pengajuan']->id, $idLolos5Besar))
                        <strong style="color: green;"> [LOLOS 5 BESAR]</strong>
                        <div style="margin: 5px 0 10px 20px;">
                            <form method="POST" action="{{ route('panitia.pengajuan.link_presentasi', $item['pengajuan']->id) }}">
                                @csrf
                                <label>Link Zoom/Meet Presentasi:</label><br>
                                <input type="text" name="link_presentasi"
                                    value="{{ $item['pengajuan']->link_presentasi }}"
                                    placeholder="https://..." style="width: 350px;">
                                <button type="submit">Simpan Link</button>
                            </form>
                        </div>
                    @endif
                </li>
            @endforeach
        </ol>
    @endif

    <h3>Kelompok: Pengembangan & Rancangan Inovasi</h3>
    @if (empty($ranking['pengembangan_rancangan']))
        <p>Belum ada nilai final.</p>
    @else
        <ol>
            @foreach ($ranking['pengembangan_rancangan'] as $item)
                <li>
                    {{ $item['pengajuan']->nama_inovasi }} ({{ $item['pengajuan']->akronim }})
                    — Nilai Proposal: {{ $item['nilai_proposal'] }}
                    @if (in_array($item['pengajuan']->id, $idLolos5Besar))
                        <strong style="color: green;"> [LOLOS 5 BESAR]</strong>
                        <div style="margin: 5px 0 10px 20px;">
                            <form method="POST" action="{{ route('panitia.pengajuan.link_presentasi', $item['pengajuan']->id) }}">
                                @csrf
                                <label>Link Zoom/Meet Presentasi:</label><br>
                                <input type="text" name="link_presentasi"
                                    value="{{ $item['pengajuan']->link_presentasi }}"
                                    placeholder="https://..." style="width: 350px;">
                                <button type="submit">Simpan Link</button>
                            </form>
                        </div>
                    @endif
                </li>
            @endforeach
        </ol>
    @endif

    <hr>

    <h2>Tahap 2 — Ranking Akhir (Proposal 75% + Presentasi 25%) — 3 Besar</h2>
    <p><em>Minimal 2 dari 3 Juri sudah submit penilaian presentasi (untuk pengajuan yang lolos 5 besar).</em></p>

    <h3>Kelompok: Inovasi Eksisting</h3>
    @if (empty($rankingAkhir['eksisting']))
        <p>Belum ada nilai akhir final.</p>
    @else
        <ol>
            @foreach ($rankingAkhir['eksisting'] as $item)
                <li>
                    {{ $item['pengajuan']->nama_inovasi }} ({{ $item['pengajuan']->akronim }})
                    — Proposal: {{ $item['nilai_proposal'] }} | Presentasi: {{ $item['nilai_presentasi'] }}
                    | <strong>Nilai Akhir: {{ $item['nilai_akhir'] }}</strong>
                    @if (in_array($item['pengajuan']->id, $id3Besar))
                        <strong style="color: red;"> [JUARA]</strong>
                    @endif
                </li>
            @endforeach
        </ol>
    @endif

    <h3>Kelompok: Pengembangan & Rancangan Inovasi</h3>
    @if (empty($rankingAkhir['pengembangan_rancangan']))
        <p>Belum ada nilai akhir final.</p>
    @else
        <ol>
            @foreach ($rankingAkhir['pengembangan_rancangan'] as $item)
                <li>
                    {{ $item['pengajuan']->nama_inovasi }} ({{ $item['pengajuan']->akronim }})
                    — Proposal: {{ $item['nilai_proposal'] }} | Presentasi: {{ $item['nilai_presentasi'] }}
                    | <strong>Nilai Akhir: {{ $item['nilai_akhir'] }}</strong>
                    @if (in_array($item['pengajuan']->id, $id3Besar))
                        <strong style="color: red;"> [JUARA]</strong>
                    @endif
                </li>
            @endforeach
        </ol>
    @endif
    <script src="{{ asset('js/prevent-double-submit.js') }}"></script>
</body>
</html>