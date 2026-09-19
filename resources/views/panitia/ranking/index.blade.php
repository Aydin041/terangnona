<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ranking - Panitia - TERANG NONA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-stone-50 min-h-screen">

    <nav class="bg-white border-b border-stone-200">
        <div class="max-w-2xl mx-auto px-4 py-3">
            <a href="{{ route('landing') }}">
                <img src="{{ asset('images/logo-terang-nona-transparan.png') }}" alt="TERANG NONA" class="h-10">
            </a>
        </div>
    </nav>

    <main class="max-w-2xl mx-auto px-4 py-8">
        <p class="mb-3"><a href="{{ route('panitia.pengajuan.index') }}" class="text-sm text-slate-500 hover:text-slate-900">← Kembali ke Daftar Pengajuan</a></p>
        <h1 class="text-2xl font-bold text-slate-900 mb-5">Ranking Peserta</h1>

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
            <p class="text-sm text-slate-500 mb-4">Minimal 2 dari 3 Juri sudah submit penilaian proposal.</p>

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
                                        <div class="mt-2 ml-4">
                                            <form method="POST" action="{{ route('panitia.pengajuan.link_presentasi', $item['pengajuan']->id) }}" class="flex flex-wrap gap-2">
                                                @csrf
                                                <input type="text" name="link_presentasi"
                                                    value="{{ $item['pengajuan']->link_presentasi }}"
                                                    placeholder="Link Zoom/Meet Presentasi"
                                                    class="rounded-lg border border-stone-300 px-3 py-1.5 text-sm w-72 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                                                <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-slate-900 text-sm font-semibold rounded-lg px-3 py-1.5">Simpan Link</button>
                                            </form>
                                        </div>
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
                                        <div class="mt-2 ml-4">
                                            <form method="POST" action="{{ route('panitia.pengajuan.link_presentasi', $item['pengajuan']->id) }}" class="flex flex-wrap gap-2">
                                                @csrf
                                                <input type="text" name="link_presentasi"
                                                    value="{{ $item['pengajuan']->link_presentasi }}"
                                                    placeholder="Link Zoom/Meet Presentasi"
                                                    class="rounded-lg border border-stone-300 px-3 py-1.5 text-sm w-72 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                                                <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-slate-900 text-sm font-semibold rounded-lg px-3 py-1.5">Simpan Link</button>
                                            </form>
                                        </div>
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
            <p class="text-sm text-slate-500 mb-4">Minimal 2 dari 3 Juri sudah submit penilaian presentasi (untuk pengajuan yang lolos 5 besar).</p>

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