@extends('layouts.pimpinan')

@section('title', 'Ranking Peserta Inovasi')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-ink tracking-tight">Peringkat &amp; Juara Kompetisi</h1>
        <p class="text-sm text-slate-500 mt-1">Laporan klasemen hasil penilaian gabungan dewan juri untuk penetapan pemenang TERANG NONA.</p>
    </div>

    @php
        $kelompokLabel = [
            'eksisting' => 'Inovasi Eksisting',
            'pengembangan_rancangan' => 'Pengembangan & Rancangan Inovasi',
        ];
    @endphp

    {{-- TAHAP 1: RANKING PROPOSAL (5 BESAR) --}}
    <section class="mb-12">
        <div class="flex items-center justify-between gap-4 mb-4 flex-wrap">
            <div>
                <span class="inline-block text-xs font-bold uppercase tracking-wider text-brand-blue bg-blue-50 border border-blue-200/60 rounded-full px-3 py-1 mb-1">Tahap 1</span>
                <h2 class="text-xl font-bold text-ink">Ranking Seleksi Proposal (Lolos 5 Besar)</h2>
            </div>
            <span class="text-xs text-slate-500 bg-white border border-slate-200/80 rounded-xl px-3 py-1.5 shadow-2xs">
                Skor gabungan setelah kuorum terpenuhi
            </span>
        </div>

        <div class="space-y-6">
            @foreach ($kelompokLabel as $kunci => $label)
                <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-7 shadow-sm">
                    <h3 class="text-base font-bold text-ink mb-4 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-brand-amber"></span>
                        Kelompok: {{ $label }}
                    </h3>

                    @if (empty($ranking[$kunci]))
                        <div class="text-center py-8 text-slate-400 text-xs sm:text-sm italic">
                            Belum ada skor proposal final.
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs sm:text-sm">
                                <thead>
                                    <tr class="border-b border-slate-100 text-slate-400 text-xs uppercase tracking-wider">
                                        <th class="py-3 px-3 font-bold w-14 text-center">Pos</th>
                                        <th class="py-3 px-3 font-bold">Nama Inovasi</th>
                                        <th class="py-3 px-3 font-bold text-right">Skor Rata-rata</th>
                                        <th class="py-3 px-3 font-bold text-center">Status Kelolosan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach ($ranking[$kunci] as $i => $item)
                                        @php
                                            $is5Besar = in_array($item['pengajuan']->id, $idLolos5Besar);
                                        @endphp
                                        <tr class="hover:bg-slate-50/70 transition-colors">
                                            <td class="py-3.5 px-3 text-center">
                                                @if ($i === 0)
                                                    <span class="w-7 h-7 rounded-full bg-amber-400 text-brand-navy font-black text-xs inline-flex items-center justify-center shadow-xs">1</span>
                                                @elseif ($i === 1)
                                                    <span class="w-7 h-7 rounded-full bg-slate-300 text-slate-800 font-black text-xs inline-flex items-center justify-center shadow-xs">2</span>
                                                @elseif ($i === 2)
                                                    <span class="w-7 h-7 rounded-full bg-amber-700 text-white font-black text-xs inline-flex items-center justify-center shadow-xs">3</span>
                                                @else
                                                    <span class="text-slate-400 text-xs font-bold">{{ $i + 1 }}</span>
                                                @endif
                                            </td>
                                            <td class="py-3.5 px-3">
                                                <div class="font-bold text-ink">{{ $item['pengajuan']->nama_inovasi }}</div>
                                                <div class="text-xs text-slate-500">{{ $item['pengajuan']->akronim }} &middot; {{ $item['pengajuan']->peserta->nama }}</div>
                                            </td>
                                            <td class="py-3.5 px-3 text-right font-black text-brand-navy text-sm sm:text-base">
                                                {{ number_format($item['nilai_proposal'], 2) }}
                                            </td>
                                            <td class="py-3.5 px-3 text-center">
                                                @if ($is5Besar)
                                                    <span class="inline-flex items-center gap-1.5 text-xs font-bold px-3 py-1 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200 shadow-2xs">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                                        Lolos 5 Besar
                                                    </span>
                                                @else
                                                    <span class="text-xs text-slate-400">&mdash;</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </section>

    {{-- TAHAP 2: RANKING AKHIR (3 BESAR / JUARA) --}}
    <section>
        <div class="flex items-center justify-between gap-4 mb-4 flex-wrap">
            <div>
                <span class="inline-block text-xs font-bold uppercase tracking-wider text-amber-700 bg-amber-50 border border-amber-200/60 rounded-full px-3 py-1 mb-1">Tahap 2 &amp; Final</span>
                <h2 class="text-xl font-bold text-ink">Ranking Akhir &amp; Penetapan Juara</h2>
            </div>
            <span class="text-xs text-slate-500 bg-white border border-slate-200/80 rounded-xl px-3 py-1.5 shadow-2xs">
                Akumulasi Nilai: Proposal (75%) + Presentasi (25%)
            </span>
        </div>

        <div class="space-y-6">
            @foreach ($kelompokLabel as $kunci => $label)
                <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-7 shadow-sm">
                    <h3 class="text-base font-bold text-ink mb-4 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-600"></span>
                        Kelompok: {{ $label }}
                    </h3>

                    @if (empty($rankingAkhir[$kunci]))
                        <div class="text-center py-8 text-slate-400 text-xs sm:text-sm italic">
                            Belum ada skor akhir final.
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs sm:text-sm">
                                <thead>
                                    <tr class="border-b border-slate-100 text-slate-400 text-xs uppercase tracking-wider">
                                        <th class="py-3 px-3 font-bold w-14 text-center">Pos</th>
                                        <th class="py-3 px-3 font-bold">Nama Inovasi</th>
                                        <th class="py-3 px-3 font-bold text-right">Nilai Proposal (75%)</th>
                                        <th class="py-3 px-3 font-bold text-right">Nilai Presentasi (25%)</th>
                                        <th class="py-3 px-3 font-bold text-right">Nilai Akhir</th>
                                        <th class="py-3 px-3 font-bold text-center">Gelar Pemenang</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach ($rankingAkhir[$kunci] as $i => $item)
                                        @php
                                            $isJuara = in_array($item['pengajuan']->id, $id3Besar);
                                        @endphp
                                        <tr class="hover:bg-slate-50/70 transition-colors {{ $isJuara ? 'bg-amber-50/20' : '' }}">
                                            <td class="py-3.5 px-3 text-center font-bold">
                                                @if ($i === 0)
                                                    <span class="w-7 h-7 rounded-full bg-amber-400 text-brand-navy font-black text-xs inline-flex items-center justify-center shadow-xs">🥇</span>
                                                @elseif ($i === 1)
                                                    <span class="w-7 h-7 rounded-full bg-slate-300 text-slate-800 font-black text-xs inline-flex items-center justify-center shadow-xs">🥈</span>
                                                @elseif ($i === 2)
                                                    <span class="w-7 h-7 rounded-full bg-amber-700 text-white font-black text-xs inline-flex items-center justify-center shadow-xs">🥉</span>
                                                @else
                                                    <span class="text-slate-400 text-xs font-bold">{{ $i + 1 }}</span>
                                                @endif
                                            </td>
                                            <td class="py-3.5 px-3">
                                                <div class="font-bold text-ink">{{ $item['pengajuan']->nama_inovasi }}</div>
                                                <div class="text-xs text-slate-500">{{ $item['pengajuan']->akronim }} &middot; {{ $item['pengajuan']->peserta->nama }}</div>
                                            </td>
                                            <td class="py-3.5 px-3 text-right text-slate-600 font-medium">
                                                {{ number_format($item['nilai_proposal'], 2) }}
                                            </td>
                                            <td class="py-3.5 px-3 text-right text-slate-600 font-medium">
                                                {{ number_format($item['nilai_presentasi'], 2) }}
                                            </td>
                                            <td class="py-3.5 px-3 text-right font-black text-brand-blue text-sm sm:text-base">
                                                {{ number_format($item['nilai_akhir'], 2) }}
                                            </td>
                                            <td class="py-3.5 px-3 text-center">
                                                @if ($isJuara)
                                                    <span class="inline-flex items-center gap-1.5 text-xs font-extrabold px-3 py-1 rounded-full bg-amber-100 text-amber-900 border border-amber-300 shadow-2xs">
                                                        🏆 Juara {{ $i + 1 }}
                                                    </span>
                                                @else
                                                    <span class="text-xs text-slate-400">&mdash;</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </section>
@endsection
