@extends('layouts.pimpinan')

@section('title', 'Ranking Peserta')

@section('content')
    <h1 class="text-2xl font-bold">Ranking Peserta</h1>
    <p class="text-slate-500 mt-1 mb-6">Hanya menampilkan nilai gabungan. Rincian nilai per juri tidak ditampilkan.</p>

    @php
        $kelompokLabel = [
            'eksisting' => 'Inovasi Eksisting',
            'pengembangan_rancangan' => 'Pengembangan & Rancangan Inovasi',
        ];
    @endphp

    <section class="mb-10">
        <h2 class="text-lg font-bold">Tahap 1 — Ranking Proposal (5 Besar)</h2>
        <p class="text-sm text-slate-500 mb-4">Nilai ditampilkan setelah jumlah juri yang sudah submit memenuhi syarat minimum.</p>

        <div class="space-y-4">
            @foreach ($kelompokLabel as $kunci => $label)
                <div class="bg-white border border-line rounded-2xl p-6">
                    <h3 class="font-semibold mb-3">Kelompok: {{ $label }}</h3>
                    @if (empty($ranking[$kunci]))
                        <p class="text-sm text-slate-400 italic">Belum ada nilai final.</p>
                    @else
                        <ol class="divide-y divide-line">
                            @foreach ($ranking[$kunci] as $i => $item)
                                <li class="py-3 flex items-start justify-between gap-3 flex-wrap">
                                    <p class="text-sm">
                                        <span class="text-slate-400 mr-2">{{ $i + 1 }}.</span>
                                        <span class="font-semibold">{{ $item['pengajuan']->nama_inovasi }} ({{ $item['pengajuan']->akronim }})</span>
                                        <span class="text-slate-500">— Nilai Proposal: {{ $item['nilai_proposal'] }}</span>
                                    </p>
                                    @if (in_array($item['pengajuan']->id, $idLolos5Besar))
                                        <span class="text-xs font-semibold px-3 py-1 rounded-full bg-green-100 text-green-800">LOLOS 5 BESAR</span>
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
        <h2 class="text-lg font-bold">Tahap 2 — Ranking Akhir (Proposal 75% + Presentasi 25%) — 3 Besar</h2>
        <p class="text-sm text-slate-500 mb-4">Untuk pengajuan yang lolos 5 besar, setelah penilaian presentasi memenuhi syarat minimum.</p>

        <div class="space-y-4">
            @foreach ($kelompokLabel as $kunci => $label)
                <div class="bg-white border border-line rounded-2xl p-6">
                    <h3 class="font-semibold mb-3">Kelompok: {{ $label }}</h3>
                    @if (empty($rankingAkhir[$kunci]))
                        <p class="text-sm text-slate-400 italic">Belum ada nilai akhir final.</p>
                    @else
                        <ol class="divide-y divide-line">
                            @foreach ($rankingAkhir[$kunci] as $i => $item)
                                <li class="py-3 flex items-start justify-between gap-3 flex-wrap">
                                    <p class="text-sm">
                                        <span class="text-slate-400 mr-2">{{ $i + 1 }}.</span>
                                        <span class="font-semibold">{{ $item['pengajuan']->nama_inovasi }} ({{ $item['pengajuan']->akronim }})</span>
                                        <span class="text-slate-500">— Proposal: {{ $item['nilai_proposal'] }} | Presentasi: {{ $item['nilai_presentasi'] }} |</span>
                                        <strong class="font-semibold">Nilai Akhir: {{ $item['nilai_akhir'] }}</strong>
                                    </p>
                                    @if (in_array($item['pengajuan']->id, $id3Besar))
                                        <span class="text-xs font-semibold px-3 py-1 rounded-full bg-amber-100 text-amber-800">JUARA</span>
                                    @endif
                                </li>
                            @endforeach
                        </ol>
                    @endif
                </div>
            @endforeach
        </div>
    </section>
@endsection