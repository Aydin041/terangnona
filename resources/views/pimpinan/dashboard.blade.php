@extends('layouts.pimpinan')

@section('title', 'Ringkasan Eksekutif')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-ink tracking-tight">Ringkasan Eksekutif Kompetisi</h1>
        <p class="text-sm text-slate-500 mt-1">Pemantauan progres keseluruhan data inovasi TERANG NONA secara waktu nyata (bersifat hanya-lihat).</p>
    </div>

    {{-- Total Pengajuan Masuk (Hero Card) --}}
    <div class="bg-gradient-to-r from-brand-navy to-brand-navy-soft rounded-3xl p-7 sm:p-9 text-white shadow-md relative overflow-hidden mb-6">
        <div class="absolute -right-10 -bottom-10 w-60 h-60 bg-brand-amber/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10 flex items-center justify-between gap-4 flex-wrap">
            <div>
                <span class="inline-block text-xs font-bold uppercase tracking-wider text-brand-amber bg-white/10 px-3 py-1 rounded-full mb-3 border border-white/10">Partisipasi Inovasi</span>
                <p class="text-slate-300 text-sm font-medium">Total Berkas Pengajuan Masuk Resmi</p>
                <div class="flex items-baseline gap-3 mt-2">
                    <span class="text-4xl sm:text-5xl font-black text-white tracking-tight">{{ $totalMasuk }}</span>
                    <span class="text-sm text-slate-300">proposal inovasi terdaftar</span>
                </div>
            </div>
            <div class="text-xs text-slate-300 bg-white/5 border border-white/10 rounded-2xl p-4 max-w-xs">
                Draft peserta yang belum disubmit ({{ $jumlahDraft }}) tidak dihitung ke dalam total verifikasi resmi.
            </div>
        </div>
    </div>

    @php
        $kartu = [
            ['label' => 'Menunggu Verifikasi', 'kunci' => 'menunggu_pemeriksaan', 'warna' => 'text-sky-600', 'bg' => 'bg-sky-50/70', 'border' => 'border-sky-200/80'],
            ['label' => 'Disetujui', 'kunci' => 'disetujui', 'warna' => 'text-emerald-600', 'bg' => 'bg-emerald-50/70', 'border' => 'border-emerald-200/80'],
            ['label' => 'Perlu Perbaikan', 'kunci' => 'perlu_perbaikan', 'warna' => 'text-amber-600', 'bg' => 'bg-amber-50/70', 'border' => 'border-amber-200/80'],
            ['label' => 'Ditolak', 'kunci' => 'ditolak', 'warna' => 'text-rose-600', 'bg' => 'bg-rose-50/70', 'border' => 'border-rose-200/80'],
        ];
    @endphp

    {{-- Kartu Status --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5 mb-8">
        @foreach ($kartu as $k)
            <a href="{{ route('pimpinan.pengajuan.index', ['status' => $k['kunci']]) }}"
                class="bg-white border {{ $k['border'] }} rounded-3xl p-5 sm:p-6 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 group flex flex-col justify-between">
                <div>
                    <div class="w-8 h-8 rounded-xl {{ $k['bg'] }} flex items-center justify-center mb-3">
                        <span class="w-2.5 h-2.5 rounded-full {{ str_replace('text-', 'bg-', $k['warna']) }}"></span>
                    </div>
                    <p class="text-xs sm:text-sm font-semibold text-slate-500">{{ $k['label'] }}</p>
                </div>
                <div class="mt-4 flex items-baseline justify-between">
                    <p class="text-3xl font-black {{ $k['warna'] }}">{{ $jumlahPerStatus[$k['kunci']] ?? 0 }}</p>
                    <span class="text-xs font-bold text-slate-400 group-hover:text-brand-navy transition-colors">Lihat &rarr;</span>
                </div>
            </a>
        @endforeach
    </div>

    {{-- Akses Cepat Menu Eksekutif --}}
    <div class="grid sm:grid-cols-2 gap-5">
        <a href="{{ route('pimpinan.pengajuan.index') }}"
            class="block bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-7 hover:border-brand-amber hover:shadow-md transition-all duration-200 group">
            <h3 class="font-bold text-ink text-lg group-hover:text-brand-navy transition-colors flex items-center gap-2">
                <span>Daftar Seluruh Pengajuan</span>
                <svg class="w-4 h-4 text-slate-400 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </h3>
            <p class="text-xs sm:text-sm text-slate-500 mt-1.5 leading-relaxed">Lihat seluruh rincian pengajuan, uraian proposal, dan bukti dukung per inovasi.</p>
        </a>

        <a href="{{ route('pimpinan.ranking.index') }}"
            class="block bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-7 hover:border-brand-amber hover:shadow-md transition-all duration-200 group">
            <h3 class="font-bold text-ink text-lg group-hover:text-brand-navy transition-colors flex items-center gap-2">
                <span>Peringkat &amp; Juara Kompetisi</span>
                <svg class="w-4 h-4 text-slate-400 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </h3>
            <p class="text-xs sm:text-sm text-slate-500 mt-1.5 leading-relaxed">Pantau perolehan skor nilai proposal dan pemeringkatan final babak presentasi.</p>
        </a>
    </div>
@endsection
