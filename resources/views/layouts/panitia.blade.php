@extends('layouts.app')

@section('peran', 'Panitia')
@section('beranda-url', route('panitia.dashboard'))
@section('logout-url', route('panitia.logout'))
@section('pengguna', Auth::guard('panitia')->user()->nama)

@section('menu')
    @php
        $aktif = fn (...$pola) => request()->routeIs(...$pola)
            ? 'text-brand-amber border-brand-amber font-semibold'
            : 'text-slate-300 border-transparent hover:text-white';
    @endphp
    <a href="{{ route('panitia.pengajuan.index') }}" class="py-1 border-b-2 transition-colors {{ $aktif('panitia.dashboard', 'panitia.pengajuan.*') }}">Pengajuan</a>
    <a href="{{ route('panitia.ranking.index') }}" class="py-1 border-b-2 transition-colors {{ $aktif('panitia.ranking.*') }}">Ranking</a>
    <a href="{{ route('panitia.laporan.index') }}" class="py-1 border-b-2 transition-colors {{ $aktif('panitia.laporan.*') }}">Laporan Nilai</a>
@endsection