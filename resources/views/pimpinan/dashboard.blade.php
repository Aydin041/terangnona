@extends('layouts.pimpinan')

@section('title', 'Ringkasan Kompetisi')

@section('content')
    <h1 class="text-2xl font-bold">Ringkasan Kompetisi</h1>
    <p class="text-slate-500 mt-1 mb-6">Halaman ini bersifat hanya-lihat.</p>

    <div class="bg-white border border-line border-t-4 border-t-brand-amber rounded-2xl p-6 mb-4">
        <p class="text-sm text-slate-500">Total Pengajuan Masuk</p>
        <p class="text-4xl font-bold mt-1">{{ $totalMasuk }}</p>
    </div>

    @php
        $kartu = [
            ['label' => 'Menunggu Pemeriksaan', 'kunci' => 'menunggu_pemeriksaan', 'warna' => 'text-sky-700'],
            ['label' => 'Disetujui', 'kunci' => 'disetujui', 'warna' => 'text-green-700'],
            ['label' => 'Perlu Perbaikan', 'kunci' => 'perlu_perbaikan', 'warna' => 'text-red-700'],
            ['label' => 'Ditolak', 'kunci' => 'ditolak', 'warna' => 'text-ink'],
        ];
    @endphp

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach ($kartu as $k)
            <a href="{{ route('pimpinan.pengajuan.index', ['status' => $k['kunci']]) }}"
                class="bg-white border border-line rounded-2xl p-5 hover:border-brand-amber transition-colors">
                <p class="text-sm text-slate-500">{{ $k['label'] }}</p>
                <p class="text-3xl font-bold mt-1 {{ $k['warna'] }}">{{ $jumlahPerStatus[$k['kunci']] ?? 0 }}</p>
            </a>
        @endforeach
    </div>
    <p class="text-xs text-slate-400 mt-3 mb-8">Draft yang belum dikirim peserta ({{ $jumlahDraft }}) tidak dihitung.</p>

    <div class="grid sm:grid-cols-2 gap-4">
        <a href="{{ route('pimpinan.pengajuan.index') }}" class="block bg-white border border-line rounded-2xl p-6 hover:border-brand-amber transition-colors">
            <p class="font-semibold">Daftar Pengajuan</p>
            <p class="text-sm text-slate-500 mt-1">Lihat pengajuan beserta isi proposalnya.</p>
        </a>
        <a href="{{ route('pimpinan.ranking.index') }}" class="block bg-white border border-line rounded-2xl p-6 hover:border-brand-amber transition-colors">
            <p class="font-semibold">Ranking</p>
            <p class="text-sm text-slate-500 mt-1">Lihat peringkat proposal dan hasil akhir.</p>
        </a>
    </div>
@endsection