@extends('layouts.pimpinan')

@section('title', 'Detail Pengajuan')

@section('content')
    <p class="mb-3"><a href="{{ route('pimpinan.pengajuan.index') }}" class="text-sm text-slate-500 hover:text-ink">← Kembali ke daftar</a></p>
    <h1 class="text-2xl font-bold">Detail Pengajuan</h1>
    <p class="text-slate-500 mt-1 mb-6">Hanya-lihat.</p>

    @include('pengajuan._riwayat', ['tampilkanPetugas' => true])
    @include('pengajuan._detail')
@endsection