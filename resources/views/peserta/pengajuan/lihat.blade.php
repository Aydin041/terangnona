@extends('layouts.peserta')

@section('title', 'Lihat Pengajuan')

@section('content')
    <p class="mb-3"><a href="{{ route('peserta.dashboard') }}" class="text-sm text-slate-500 hover:text-ink">← Kembali ke dashboard</a></p>
    <h1 class="text-2xl font-bold">{{ $pengajuan->nama_inovasi }}</h1>
    <p class="text-slate-500 mt-1 mb-6">
        Hanya untuk dilihat.
        @if ($pengajuan->status === 'perlu_perbaikan')
            Untuk mengubah isian, gunakan tombol "Perbaiki Pengajuan Ini" di dashboard.
        @endif
    </p>

    @include('pengajuan._riwayat', ['tampilkanPetugas' => false])
    @include('pengajuan._detail')
@endsection