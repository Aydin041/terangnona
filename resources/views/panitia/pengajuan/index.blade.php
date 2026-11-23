@extends('layouts.panitia')

@section('title', 'Daftar Pengajuan Masuk')

@section('content')
    <div class="flex items-start justify-between gap-4 flex-wrap mb-8">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-ink tracking-tight">Verifikasi Pengajuan Inovasi</h1>
            <p class="text-sm text-slate-500 mt-1">Periksa kelengkapan administrasi, setujui berkas, atau kembalikan untuk revisi peserta.</p>
        </div>
    </div>

    @if (session('sukses'))
        <div class="mb-6 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm p-4 font-medium">
            {{ session('sukses') }}
        </div>
    @endif

    @php
        $statusAktif = request('status');
        $chip = fn ($nilai) => $statusAktif === $nilai
            ? 'bg-brand-navy text-white border-brand-navy shadow-sm'
            : 'bg-white text-slate-600 border-slate-200 hover:border-brand-amber hover:text-brand-navy shadow-2xs';
        $filter = [
            [null, 'Semua Pengajuan'],
            ['menunggu_pemeriksaan', 'Menunggu Verifikasi'],
            ['disetujui', 'Disetujui'],
            ['perlu_perbaikan', 'Perlu Revisi'],
            ['ditolak', 'Ditolak'],
        ];
    @endphp

    {{-- Filter Chips Tab --}}
    <div class="flex flex-wrap gap-2 mb-6">
        @foreach ($filter as [$nilai, $label])
            <a href="{{ $nilai ? route('panitia.pengajuan.index', ['status' => $nilai]) : route('panitia.pengajuan.index') }}"
                class="text-xs sm:text-sm font-semibold rounded-xl border px-4 py-2 transition-all duration-200 {{ $chip($nilai) }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    @if ($daftarPengajuan->isEmpty())
        <div class="bg-white border border-slate-200/80 rounded-3xl p-12 text-center shadow-sm">
            <div class="w-16 h-16 rounded-2xl bg-slate-50 border border-slate-200/60 flex items-center justify-center mx-auto mb-4 text-slate-400">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <h3 class="font-bold text-ink text-lg">Tidak Ada Pengajuan</h3>
            <p class="text-sm text-slate-500 mt-1">Belum ada pengajuan dengan filter status ini.</p>
        </div>
    @else
        <div class="space-y-3.5">
            @foreach ($daftarPengajuan as $item)
                <a href="{{ route('panitia.pengajuan.detail', $item->uuid) }}"
                    class="block bg-white border border-slate-200/80 rounded-2xl p-5 sm:p-6 hover:border-brand-amber hover:shadow-md transition-all duration-200 group">
                    <div class="flex items-start justify-between gap-4 flex-wrap">
                        <div class="min-w-0 flex-1">
                            <h2 class="text-base sm:text-lg font-bold text-ink group-hover:text-brand-navy transition-colors">
                                {{ $item->nama_inovasi }} <span class="text-slate-500 font-medium">({{ $item->akronim }})</span>
                            </h2>
                            <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-xs sm:text-sm text-slate-500 mt-1.5">
                                <span>Inovator: <strong class="text-slate-700 font-semibold">{{ $item->peserta->nama }}</strong></span>
                                <span class="text-slate-300">&bull;</span>
                                <span>Kategori: <strong class="text-slate-700 font-semibold">{{ $item->kategori->nama }}</strong></span>
                                <span class="text-slate-300">&bull;</span>
                                <span>Unit: <strong class="text-slate-700 font-semibold">{{ $item->unitKerja->nama ?? '-' }}</strong></span>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <x-badge-status :status="$item->status" />
                            <svg class="w-5 h-5 text-slate-400 group-hover:text-brand-amber group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
@endsection
