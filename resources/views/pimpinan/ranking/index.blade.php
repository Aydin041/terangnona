<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ranking - Pimpinan - TERANG NONA</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-stone-50 min-h-screen">

    @include('pimpinan._nav')

    <main class="max-w-4xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold text-slate-900 mb-1">Ranking Peserta</h1>
        <p class="text-sm text-slate-500 mb-6">Hanya menampilkan nilai gabungan. Rincian nilai per juri tidak ditampilkan.</p>

        @php
            $kelompokLabel = [
                'eksisting' => 'Inovasi Eksisting',
                'pengembangan_rancangan' => 'Pengembangan & Rancangan Inovasi',
            ];
        @endphp

        <section class="mb-10">
            <h2 class="text-lg font-bold text-slate-900">Tahap 1 — Ranking Proposal (5 Besar)</h2>
            <p class="text-sm text-slate-500 mb-4">Nilai ditampilkan setelah jumlah juri yang sudah submit memenuhi syarat minimum.</p>

            <div class="space-y-4">
                @foreach ($kelompokLabel as $kunci => $label)
                    <div class="bg-white border border-stone-200 rounded-xl p-5">
                        <h3 class="font-semibold text-slate-900 mb-3">Kelompok: {{ $label }}</h3>
                        @if (empty($ranking[$kunci]))
                            <p class="text-sm text-slate-400 italic">Belum ada nilai final.</p>
                        @else
                            <ol class="list-decimal list-inside space-y-3">
                                @foreach ($ranking[$kunci] as $item)
                                    <li class="text-sm text-slate-800">
                                        <span class="font-medium">{{ $item['pengajuan']->nama_inovasi }} ({{ $item['pengajuan']->akronim }})</span>
                                        — Nilai Proposal: {{ $item['nilai_proposal'] }}
                                        @if (in_array($item['pengajuan']->id, $idLolos5Besar))
                                            <span class="ml-1 text-xs font-semibold px-2 py-0.5 rounded-full bg-green-100 text-green-800">LOLOS 5 BESAR</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ol>
                        @endif
                    </div>
                @endforeach
            </div>
        </section>

        <section>
            <h2 class="text-lg font-bold text-slate-900">Tahap 2 — Ranking Akhir (Proposal 75% + Presentasi 25%) — 3 Besar</h2>
            <p class="text-sm text-slate-500 mb-4">Untuk pengajuan yang lolos 5 besar, setelah penilaian presentasi memenuhi syarat minimum.</p>

            <div class="space-y-4">
                @foreach ($kelompokLabel as $kunci => $label)
                    <div class="bg-white border border-stone-200 rounded-xl p-5">
                        <h3 class="font-semibold text-slate-900 mb-3">Kelompok: {{ $label }}</h3>
                        @if (empty($rankingAkhir[$kunci]))
                            <p class="text-sm text-slate-400 italic">Belum ada nilai akhir final.</p>
                        @else
                            <ol class="list-decimal list-inside space-y-2">
                                @foreach ($rankingAkhir[$kunci] as $item)
                                    <li class="text-sm text-slate-800">
                                        <span class="font-medium">{{ $item['pengajuan']->nama_inovasi }} ({{ $item['pengajuan']->akronim }})</span>
                                        — Proposal: {{ $item['nilai_proposal'] }} | Presentasi: {{ $item['nilai_presentasi'] }}
                                        | <strong class="text-slate-900">Nilai Akhir: {{ $item['nilai_akhir'] }}</strong>
                                        @if (in_array($item['pengajuan']->id, $id3Besar))
                                            <span class="ml-1 text-xs font-semibold px-2 py-0.5 rounded-full bg-amber-100 text-amber-800">JUARA</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ol>
                        @endif
                    </div>
                @endforeach
            </div>
        </section>
    </main>

    <script src="{{ asset('js/prevent-double-submit.js') }}"></script>
</body>
</html>