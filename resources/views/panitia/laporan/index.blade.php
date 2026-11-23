@extends('layouts.panitia')

@section('title', 'Laporan Nilai Dewan Juri')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-ink tracking-tight">Laporan Rekapitulasi Nilai</h1>
        <p class="text-sm text-slate-500 mt-1">Transparansi rekap nilai dari setiap dewan juri per komponen inovasi (bersifat hanya-lihat).</p>
    </div>

    @if (empty($laporan))
        <div class="bg-white border border-slate-200/80 rounded-3xl p-12 text-center shadow-sm">
            <div class="w-16 h-16 rounded-2xl bg-slate-50 border border-slate-200/60 flex items-center justify-center mx-auto mb-4 text-slate-400">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <h3 class="font-bold text-ink text-lg">Belum Ada Penilaian</h3>
            <p class="text-sm text-slate-500 mt-1">Belum ada pengajuan inovasi yang telah dinilai oleh dewan juri.</p>
        </div>
    @else
        <div class="space-y-6">
            @foreach ($laporan as $item)
                <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-8 shadow-sm">
                    <div class="flex items-start justify-between gap-4 flex-wrap pb-4 mb-6 border-b border-slate-100">
                        <div>
                            <h2 class="text-lg sm:text-xl font-bold text-ink">{{ $item['pengajuan']->nama_inovasi }} <span class="text-slate-500 font-medium">({{ $item['pengajuan']->akronim }})</span></h2>
                            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                                Kategori: <strong class="text-slate-700 font-semibold">{{ $item['pengajuan']->kategori->nama ?? '-' }}</strong> &middot; Inovator: {{ $item['pengajuan']->peserta->nama }}
                            </p>
                        </div>
                        <x-badge-status :status="$item['pengajuan']->status" />
                    </div>

                    {{-- Nilai Tahap Proposal --}}
                    @if ($item['proposal']->isNotEmpty())
                        <div class="mb-6">
                            <h3 class="text-xs sm:text-sm font-bold uppercase tracking-wider text-slate-400 mb-3 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-brand-amber"></span>
                                Rekap Nilai Proposal
                            </h3>
                            <div class="grid md:grid-cols-2 gap-4">
                                @foreach ($item['proposal'] as $submisi)
                                    <div class="bg-slate-50/70 border border-slate-200/70 rounded-2xl p-5 shadow-2xs">
                                        <div class="flex items-center justify-between gap-2 pb-2.5 mb-3 border-b border-slate-200/60">
                                            <div class="font-bold text-ink text-sm sm:text-base">{{ $submisi->juri->nama }}</div>
                                            <span class="text-2xs sm:text-xs font-bold px-2.5 py-0.5 rounded-full {{ $submisi->status === 'submitted' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                                {{ $submisi->status === 'submitted' ? 'Submitted' : 'Draft Juri' }}
                                            </span>
                                        </div>
                                        <div class="space-y-1.5 text-xs sm:text-sm">
                                            @foreach ($submisi->nilaiKomponen as $nk)
                                                <div class="flex items-center justify-between text-slate-600 py-1 border-b border-slate-100/80 last:border-0">
                                                    <span class="truncate pr-2">{{ $nk->komponen->nama }}</span>
                                                    <span class="font-black text-brand-navy shrink-0">{{ $nk->nilai ?? '-' }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Nilai Tahap Presentasi --}}
                    @if ($item['presentasi']->isNotEmpty())
                        <div>
                            <h3 class="text-xs sm:text-sm font-bold uppercase tracking-wider text-slate-400 mb-3 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-brand-blue"></span>
                                Rekap Nilai Presentasi (Babak Final)
                            </h3>
                            <div class="grid md:grid-cols-2 gap-4">
                                @foreach ($item['presentasi'] as $submisi)
                                    <div class="bg-slate-50/70 border border-slate-200/70 rounded-2xl p-5 shadow-2xs">
                                        <div class="flex items-center justify-between gap-2 pb-2.5 mb-3 border-b border-slate-200/60">
                                            <div class="font-bold text-ink text-sm sm:text-base">{{ $submisi->juri->nama }}</div>
                                            <span class="text-2xs sm:text-xs font-bold px-2.5 py-0.5 rounded-full {{ $submisi->status === 'submitted' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                                {{ $submisi->status === 'submitted' ? 'Submitted' : 'Draft Juri' }}
                                            </span>
                                        </div>
                                        <div class="space-y-1.5 text-xs sm:text-sm">
                                            @foreach ($submisi->nilaiAspek as $na)
                                                <div class="flex items-center justify-between text-slate-600 py-1 border-b border-slate-100/80 last:border-0">
                                                    <span class="truncate pr-2">{{ \App\Http\Controllers\Juri\PenilaianController::ASPEK_PRESENTASI[$na->aspek] ?? $na->aspek }}</span>
                                                    <span class="font-black text-brand-navy shrink-0">{{ $na->nilai ?? '-' }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
@endsection
