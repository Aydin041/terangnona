@extends('layouts.app')

@section('peran', 'Pimpinan')
@section('beranda-url', route('pimpinan.dashboard'))
@section('logout-url', route('pimpinan.logout'))
@section('pengguna', Auth::guard('pimpinan')->user()->nama)

@section('menu')
    @php
        $aktif = fn ($pola) => request()->routeIs($pola)
            ? 'text-brand-amber border-brand-amber font-semibold'
            : 'text-slate-300 border-transparent hover:text-white';
    @endphp
    <a href="{{ route('pimpinan.dashboard') }}" class="py-1 border-b-2 transition-colors {{ $aktif('pimpinan.dashboard') }}">Ringkasan</a>
    <a href="{{ route('pimpinan.pengajuan.index') }}" class="py-1 border-b-2 transition-colors {{ $aktif('pimpinan.pengajuan.*') }}">Daftar Pengajuan</a>
    <a href="{{ route('pimpinan.ranking.index') }}" class="py-1 border-b-2 transition-colors {{ $aktif('pimpinan.ranking.*') }}">Ranking</a>
@endsection