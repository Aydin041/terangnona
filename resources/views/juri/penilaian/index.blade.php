@extends('layouts.juri')

@section('title', 'Daftar Penilaian')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-ink tracking-tight">Portal Penilaian Dewan Juri</h1>
        <p class="text-sm text-slate-500 mt-1">Pilih tahapan evaluasi kompetisi untuk memberikan skoring dan evaluasi proposal inovasi.</p>
    </div>

    @if (session('sukses'))
        <div class="mb-6 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm p-4 font-medium">
            {{ session('sukses') }}
        </div>
    @endif

    <div class="grid sm:grid-cols-2 gap-6">
        {{-- Card Penilaian Proposal --}}
        <a href="{{ route('juri.penilaian.daftar.proposal') }}"
            class="block bg-white border border-slate-200/80 rounded-3xl p-7 hover:border-brand-amber hover:shadow-lg transition-all duration-200 group">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 border border-amber-200/60 flex items-center justify-center mb-5 text-brand-amber-dark group-hover:scale-105 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <h2 class="text-xl font-bold text-ink group-hover:text-brand-navy transition-colors">Penilaian Proposal</h2>
            <p class="text-sm text-slate-500 mt-1.5 leading-relaxed">Evaluasi dan berikan nilai untuk seluruh berkas proposal pengajuan yang telah disetujui Panitia.</p>

            <div class="mt-5 pt-4 border-t border-slate-100 flex flex-wrap gap-2 items-center">
                @if (($jumlahPerbaikanProposal ?? 0) > 0)
                    <span class="inline-flex items-center text-xs font-bold rounded-full bg-amber-100 text-amber-800 px-3 py-1">
                        {{ $jumlahPerbaikanProposal }} perlu perbaikan
                    </span>
                @endif
                @if (($jumlahDitolakProposal ?? 0) > 0)
                    <span class="inline-flex items-center text-xs font-bold rounded-full bg-rose-50 text-rose-700 px-3 py-1">
                        {{ $jumlahDitolakProposal }} koreksi ditolak Admin
                    </span>
                @endif
                <span class="text-xs font-bold text-brand-blue group-hover:underline ml-auto inline-flex items-center gap-1">
                    Masuk Penilaian &rarr;
                </span>
            </div>
        </a>

        {{-- Card Penilaian Presentasi --}}
        <a href="{{ route('juri.penilaian.daftar.presentasi') }}"
            class="block bg-white border border-slate-200/80 rounded-3xl p-7 hover:border-brand-amber hover:shadow-lg transition-all duration-200 group">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 border border-blue-200/60 flex items-center justify-center mb-5 text-brand-blue group-hover:scale-105 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
            </div>
            <h2 class="text-xl font-bold text-ink group-hover:text-brand-navy transition-colors">Penilaian Presentasi</h2>
            <p class="text-sm text-slate-500 mt-1.5 leading-relaxed">Berikan skor wawancara dan pemaparan untuk inovasi yang berhasil lolos ke babak 5 besar.</p>

            <div class="mt-5 pt-4 border-t border-slate-100 flex flex-wrap gap-2 items-center">
                @if (($jumlahPerbaikanPresentasi ?? 0) > 0)
                    <span class="inline-flex items-center text-xs font-bold rounded-full bg-amber-100 text-amber-800 px-3 py-1">
                        {{ $jumlahPerbaikanPresentasi }} perlu perbaikan
                    </span>
                @endif
                @if (($jumlahDitolakPresentasi ?? 0) > 0)
                    <span class="inline-flex items-center text-xs font-bold rounded-full bg-rose-50 text-rose-700 px-3 py-1">
                        {{ $jumlahDitolakPresentasi }} koreksi ditolak Admin
                    </span>
                @endif
                <span class="text-xs font-bold text-brand-blue group-hover:underline ml-auto inline-flex items-center gap-1">
                    Masuk Penilaian &rarr;
                </span>
            </div>
        </a>
    </div>
@endsection
