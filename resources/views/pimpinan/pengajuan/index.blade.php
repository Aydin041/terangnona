@extends('layouts.pimpinan')

@section('title', 'Daftar Pengajuan')

@section('content')
    <h1 class="text-2xl font-bold">Daftar Pengajuan</h1>
    <p class="text-slate-500 mt-1 mb-5">Hanya-lihat. Pengajuan yang masih draft tidak ditampilkan.</p>

    @php
        $chip = fn ($nilai) => $status === $nilai
            ? 'bg-brand-navy text-white border-brand-navy'
            : 'bg-white text-slate-700 border-line hover:border-brand-amber';
        $filter = [
            [null, 'Semua'],
            ['menunggu_pemeriksaan', 'Menunggu Pemeriksaan'],
            ['disetujui', 'Disetujui'],
            ['perlu_perbaikan', 'Perlu Perbaikan'],
            ['ditolak', 'Ditolak'],
        ];
    @endphp

    <div class="flex flex-wrap gap-2 mb-6">
        @foreach ($filter as [$nilai, $label])
            <a href="{{ $nilai ? route('pimpinan.pengajuan.index', ['status' => $nilai]) : route('pimpinan.pengajuan.index') }}"
                class="text-sm font-medium rounded-full border px-4 py-1.5 transition-colors {{ $chip($nilai) }}">{{ $label }}</a>
        @endforeach
    </div>

    @if ($daftarPengajuan->isEmpty())
        <div class="bg-white border border-line rounded-2xl p-8 text-center text-slate-500">
            Tidak ada pengajuan.
        </div>
    @else
        <div class="space-y-3">
            @foreach ($daftarPengajuan as $item)
                <a href="{{ route('pimpinan.pengajuan.detail', $item->uuid) }}"
                    class="block bg-white border border-line rounded-2xl p-5 hover:border-brand-amber transition-colors">
                    <div class="flex items-start justify-between gap-3 flex-wrap">
                        <div class="min-w-0">
                            <p class="font-semibold">{{ $item->nama_inovasi }} ({{ $item->akronim }})</p>
                            <p class="text-sm text-slate-500 mt-0.5">Peserta: {{ $item->peserta->nama }} | Kategori: {{ $item->kategori->nama }}</p>
                        </div>
                        <x-badge-status :status="$item->status" />
                    </div>
                </a>
            @endforeach
        </div>
    @endif
@endsection