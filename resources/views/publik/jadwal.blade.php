@extends('layouts.publik')

@section('judul', 'Jadwal - TERANG NONA ' . $tahunKompetisi)

@section('content')
    <section class="max-w-5xl mx-auto px-4 sm:px-6 pt-10 pb-20">
        <a href="{{ route('landing') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-500 hover:text-brand-navy transition-colors mb-6 group">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Beranda
        </a>

        <div class="mb-8">
            <span class="inline-block text-xs font-bold tracking-wider text-brand-amber-dark bg-amber-50 border border-amber-200/60 rounded-full px-3 py-1 uppercase">Timeline</span>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-ink mt-2 mb-3">Jadwal Penting Kegiatan</h1>
            <p class="text-sm sm:text-base text-slate-600">Pantau seluruh linimasa dan tahapan pelaksanaan TERANG NONA {{ $tahunKompetisi }}.</p>
        </div>

        {{-- Indikator Keterangan --}}
        <div class="flex flex-wrap items-center gap-x-6 gap-y-2 text-xs sm:text-sm text-slate-600 bg-white border border-slate-200/80 rounded-2xl p-4 mb-6 shadow-sm">
            <span class="flex items-center gap-2"><span class="w-3 h-3 rounded-full border-2 border-slate-300"></span> Belum dimulai</span>
            <span class="flex items-center gap-2"><span class="w-3 h-3 rounded-full border-2 border-brand-amber bg-amber-50"></span> Sedang berlangsung</span>
            <span class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-brand-amber"></span> Selesai / Lewat</span>
            <span class="text-xs text-slate-400 ml-auto hidden sm:inline">&ast; Status diperbarui otomatis berdasarkan tanggal sistem</span>
        </div>

        <ol class="grid md:grid-cols-2 gap-4">
            @foreach ($tahapList as $i => $t)
                <li class="bg-white border rounded-2xl p-4 sm:p-5 flex items-center gap-4 transition-all duration-200 hover:shadow-md
                    {{ $t['status'] === 'berlangsung' ? 'border-brand-amber ring-2 ring-brand-amber/20 shadow-sm' : 'border-slate-200/80' }}">
                    <span class="shrink-0 w-10 h-10 rounded-xl flex items-center justify-center text-sm font-bold shadow-sm transition-colors
                        {{ $t['status'] === 'lewat' ? 'bg-brand-amber text-brand-navy' : ($t['status'] === 'berlangsung' ? 'bg-amber-100 text-brand-amber-dark border border-brand-amber' : 'bg-slate-100 text-slate-400 border border-slate-200') }}">
                        @if ($t['status'] === 'lewat')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        @else
                            {{ $i + 1 }}
                        @endif
                    </span>
                    <div class="min-w-0 flex-1 flex flex-wrap items-center justify-between gap-x-3 gap-y-1">
                        <div class="space-y-1">
                            <p class="text-sm sm:text-base font-bold text-ink leading-snug">{{ $t['nama'] }}</p>
                            @if ($t['status'] === 'berlangsung')
                                <span class="inline-block text-xs font-semibold px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-800 border border-amber-200">{{ $labelStatus['berlangsung'] }}</span>
                            @endif
                        </div>
                        <span class="text-xs sm:text-sm font-semibold text-slate-500 bg-slate-50 px-2.5 py-1 rounded-lg border border-slate-200/60">{{ $t['teks_ringkas'] }}</span>
                    </div>
                </li>
            @endforeach
        </ol>
    </section>
@endsection
