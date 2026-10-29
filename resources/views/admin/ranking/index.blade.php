@extends('layouts.admin')

@section('title', 'Ranking Peserta')

@section('content')
    @php
        $minimalJuri = \App\Models\Pengaturan::minimalJuriSubmit();
        $kelompokLabel = [
            'eksisting' => 'Inovasi Eksisting',
            'pengembangan_rancangan' => 'Pengembangan & Rancangan Inovasi',
        ];
    @endphp

    <div class="flex items-start justify-between gap-4 flex-wrap mb-6">
        <div>
            <h1 class="text-2xl font-bold">Ranking Peserta</h1>
            <p class="text-slate-500 mt-1">Peringkat proposal dan hasil akhir per kelompok.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.export.nilai.proposal') }}"
                class="text-sm font-medium border border-line bg-white hover:border-brand-amber rounded-xl px-4 py-2 transition-colors">
                Unduh Nilai Proposal (Excel)
            </a>
            <a href="{{ route('admin.export.nilai.presentasi') }}"
                class="text-sm font-medium border border-line bg-white hover:border-brand-amber rounded-xl px-4 py-2 transition-colors">
                Unduh Nilai Presentasi (Excel)
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="mb-5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm p-3">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('sukses'))
        <div class="mb-5 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm p-3">
            {{ session('sukses') }}
        </div>
    @endif

    <section class="mb-10">
        <h2 class="text-lg font-bold">Tahap 1 — Ranking Proposal (5 Besar)</h2>
        <p class="text-sm text-slate-500 mb-4">Minimal {{ $minimalJuri }} Juri sudah submit penilaian proposal.</p>

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
        <p class="text-sm text-slate-500 mb-4">Minimal {{ $minimalJuri }} Juri sudah submit penilaian presentasi (untuk pengajuan yang lolos 5 besar).</p>

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