@extends('layouts.publik')

@section('judul', 'Jadwal - TERANG NONA ' . $tahunKompetisi)

@section('content')
    <section class="max-w-6xl mx-auto px-4 sm:px-6" style="padding-top:2.5rem;padding-bottom:5rem">
        <a href="{{ route('landing') }}" class="text-sm text-slate-500 hover:text-ink">← Kembali ke Beranda</a>

        <p class="text-xs font-bold tracking-widest text-brand-amber-dark uppercase" style="margin-top:2.5rem">Jadwal</p>
        <h1 class="text-3xl font-bold mt-1 mb-3">Jadwal Penting</h1>

        <div class="flex flex-wrap items-center gap-x-5 gap-y-1 text-sm text-slate-500 mb-5">
            <span class="flex items-center gap-2"><span class="w-3 h-3 rounded-full border-2 border-line"></span> Belum dimulai</span>
            <span class="flex items-center gap-2"><span class="w-3 h-3 rounded-full border-2 border-brand-amber"></span> Sedang berlangsung</span>
            <span class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-brand-amber"></span> Sudah lewat</span>
            <span class="text-xs text-slate-400">Status berubah sendiri mengikuti tanggal.</span>
        </div>

        <ol class="grid md:grid-cols-2 gap-3">
            @foreach ($tahapList as $i => $t)
                <li class="bg-white border border-line rounded-2xl p-4 flex items-center gap-4 {{ $t['status'] === 'berlangsung' ? 'border-brand-amber ring-1 ring-brand-amber' : '' }}">
                    <span class="shrink-0 w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold
                        {{ $t['status'] === 'lewat' ? 'bg-brand-amber text-brand-navy' : ($t['status'] === 'berlangsung' ? 'border-2 border-brand-amber text-brand-amber-dark' : 'border-2 border-line text-slate-400') }}">
                        @if ($t['status'] === 'lewat') ✓ @else {{ $i + 1 }} @endif
                    </span>
                    <div class="min-w-0 flex-1 flex flex-wrap items-center justify-between gap-x-3 gap-y-1">
                        <div class="flex flex-wrap items-center gap-x-3 gap-y-1">
                            <p class="text-sm font-medium leading-snug">{{ $t['nama'] }}</p>
                            @if ($t['status'] === 'berlangsung')
                                <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-800">{{ $labelStatus['berlangsung'] }}</span>
                            @endif
                        </div>
                        <span class="text-sm font-semibold text-slate-500">{{ $t['teks_ringkas'] }}</span>
                    </div>
                </li>
            @endforeach
        </ol>
    </section>
@endsection