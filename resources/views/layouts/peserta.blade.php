@extends('layouts.app')

@section('peran', 'Peserta')
@section('beranda-url', route('peserta.dashboard'))
@section('logout-url', route('peserta.logout'))
@section('pengguna', Auth::guard('peserta')->user()->nama)

@section('menu')
    @php
        $aktif = fn (...$pola) => request()->routeIs(...$pola)
            ? 'text-brand-amber border-brand-amber font-semibold'
            : 'text-slate-300 border-transparent hover:text-white';
    @endphp
    <a href="{{ route('peserta.dashboard') }}" class="py-1 border-b-2 transition-colors {{ $aktif('peserta.dashboard', 'peserta.pengajuan.*') }}">Dashboard Saya</a>
    <a href="{{ route('peserta.survei.form') }}" class="py-1 border-b-2 transition-colors {{ $aktif('peserta.survei.*') }}">Survei</a>
@endsection