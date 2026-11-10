@extends('layouts.admin')

@section('title', 'Kelola Pengajuan')

@section('content')
    <h1 class="text-2xl font-bold">Kelola Pengajuan</h1>
    <p class="text-slate-500 mt-1 mb-5">Admin dapat menghapus pengajuan berstatus apa pun. Penghapusan bersifat permanen dan ikut menghapus nilai juri serta riwayatnya.</p>

    @if ($errors->any())
        <div class="mb-5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm p-3">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    @if (session('sukses'))
        <div class="mb-5 rounded-xl bg-green-50 border border-green-200 text-green-800 text-sm p-4 break-words">
            {{ session('sukses') }}
        </div>
    @endif

    @php
        $chip = fn ($nilai) => $status === $nilai
            ? 'bg-brand-navy text-white border-brand-navy'
            : 'bg-white text-slate-700 border-line hover:border-brand-amber';
        $filter = [
            [null, 'Semua'],
            ['draft', 'Draft'],
            ['menunggu_pemeriksaan', 'Menunggu Pemeriksaan'],
            ['disetujui', 'Disetujui'],
            ['perlu_perbaikan', 'Perlu Perbaikan'],
            ['ditolak', 'Ditolak'],
        ];
    @endphp

    <form method="GET" action="{{ route('admin.pengajuan.index') }}" class="flex gap-2 mb-4">
        @if ($status)
            <input type="hidden" name="status" value="{{ $status }}">
        @endif
        <input type="text" name="q" value="{{ $cari }}" placeholder="Cari nama inovasi, akronim, atau peserta"
            class="flex-1 border border-line rounded-xl px-4 py-2 text-sm focus:outline-none focus:border-brand-amber">
        <button type="submit" class="text-sm font-medium border border-line hover:border-brand-amber rounded-xl px-4 py-2 transition-colors">Cari</button>
    </form>

    <div class="flex flex-wrap gap-2 mb-6">
        @foreach ($filter as [$nilai, $label])
            <a href="{{ route('admin.pengajuan.index', array_filter(['status' => $nilai, 'q' => $cari])) }}"
                class="text-sm font-medium rounded-full border px-4 py-1.5 transition-colors {{ $chip($nilai) }}">{{ $label }}</a>
        @endforeach
    </div>

    @if ($daftarPengajuan->isEmpty())
        <div class="bg-white border border-line rounded-2xl p-8 text-center text-slate-500">Tidak ada pengajuan.</div>
    @else
        <div class="space-y-3">
            @foreach ($daftarPengajuan as $item)
                <div class="bg-white border border-line rounded-2xl p-5 flex items-center justify-between flex-wrap gap-3">
                    <div class="min-w-0">
                        <p class="font-semibold break-words">{{ $item->nama_inovasi }} ({{ $item->akronim }})</p>
                        <p class="text-sm text-slate-500 mt-0.5">Peserta: {{ $item->peserta->nama }} | Kategori: {{ $item->kategori->nama }}</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <x-badge-status :status="$item->status" />
                        <a href="{{ route('admin.pengajuan.hapus.form', $item->uuid) }}"
                            class="text-sm font-medium border border-red-300 text-red-700 hover:bg-red-50 rounded-xl px-4 py-2 transition-colors">
                            Hapus
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection