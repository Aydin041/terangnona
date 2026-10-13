<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ranking - Panitia - TERANG NONA</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-stone-50 min-h-screen">

    <nav class="bg-white border-b border-stone-200">
        <div class="max-w-2xl mx-auto px-4 py-3">
            <a href="{{ route('panitia.dashboard') }}">
                <img src="{{ asset('images/logo-terang-nona-transparan.png') }}" alt="TERANG NONA" class="h-10">
            </a>
            <span class="text-sm text-slate-500">Login sebagai: <strong class="text-slate-700">{{ Auth::guard('panitia')->user()->nama }}</strong></span>
        </div>
    </nav>

    <main class="max-w-2xl mx-auto px-4 py-8">
        <p class="mb-3"><a href="{{ route('panitia.pengajuan.index') }}" class="text-sm text-slate-500 hover:text-slate-900">← Kembali ke Daftar Pengajuan</a></p>
        <h1 class="text-2xl font-bold text-slate-900 mb-3">Ranking Peserta</h1>

        <div class="flex flex-wrap gap-2 mb-5">
            <a href="{{ route('panitia.export.nilai.proposal') }}"
                class="text-sm border border-stone-300 text-slate-700 hover:bg-stone-100 rounded-lg px-3 py-1.5">
                Export Nilai Proposal (CSV)
            </a>
            <a href="{{ route('panitia.export.nilai.presentasi') }}"
                class="text-sm border border-stone-300 text-slate-700 hover:bg-stone-100 rounded-lg px-3 py-1.5">
                Export Nilai Presentasi (CSV)
            </a>
        </div>

        @if ($errors->any())
            <div class="mb-4 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm p-3">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('sukses'))
            <div class="mb-4 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm p-3">
                {{ session('sukses') }}
            </div>
        @endif

        <section class="mb-10">
            <h2 class="text-lg font-bold text-slate-900">Tahap 1 — Ranking Proposal (5 Besar)</h2>
            <p class="text-sm text-slate-500 mb-4">Minimal {{ \App\Models\Pengaturan::minimalJuriSubmit() }} Juri sudah submit penilaian proposal.</p>

            <div class="space-y-6">
                <div class="bg-white border border-stone-200 rounded-xl p-5">
                    <h3 class="font-semibold text-slate-900 mb-3">Kelompok: Inovasi Eksisting</h3>
                    @if (empty($ranking['eksisting']))
                        <p class="text-sm text-slate-400 italic">Belum ada nilai final.</p>
                    @else
                        <ol class="list-decimal list-inside space-y-3">
                            @foreach ($ranking['eksisting'] as $item)
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

                <div class="bg-white border border-stone-200 rounded-xl p-5">
                    <h3 class="font-semibold text-slate-900 mb-3">Kelompok: Pengembangan & Rancangan Inovasi</h3>
                    @if (empty($ranking['pengembangan_rancangan']))
                        <p class="text-sm text-slate-400 italic">Belum ada nilai final.</p>
                    @else
                        <ol class="list-decimal list-inside space-y-3">
                            @foreach ($ranking['pengembangan_rancangan'] as $item)
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
            </div>
        </section>

        <section>
            <h2 class="text-lg font-bold text-slate-900">Tahap 2 — Ranking Akhir (Proposal 75% + Presentasi 25%) — 3 Besar</h2>
            <p class="text-sm text-slate-500 mb-4">Minimal {{ \App\Models\Pengaturan::minimalJuriSubmit() }} Juri sudah submit penilaian presentasi (untuk pengajuan yang lolos 5 besar).</p>

            <div class="space-y-6">
                <div class="bg-white border border-stone-200 rounded-xl p-5">
                    <h3 class="font-semibold text-slate-900 mb-3">Kelompok: Inovasi Eksisting</h3>
                    @if (empty($rankingAkhir['eksisting']))
                        <p class="text-sm text-slate-400 italic">Belum ada nilai akhir final.</p>
                    @else
                        <ol class="list-decimal list-inside space-y-2">
                            @foreach ($rankingAkhir['eksisting'] as $item)
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

                <div class="bg-white border border-stone-200 rounded-xl p-5">
                    <h3 class="font-semibold text-slate-900 mb-3">Kelompok: Pengembangan & Rancangan Inovasi</h3>
                    @if (empty($rankingAkhir['pengembangan_rancangan']))
                        <p class="text-sm text-slate-400 italic">Belum ada nilai akhir final.</p>
                    @else
                        <ol class="list-decimal list-inside space-y-2">
                            @foreach ($rankingAkhir['pengembangan_rancangan'] as $item)
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
            </div>
        </section>
    </main>

    <script src="{{ asset('js/prevent-double-submit.js') }}"></script>
</body>
</html>