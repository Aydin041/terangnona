@extends('layouts.app')

@section('peran', 'Peserta')
@section('beranda-url', route('peserta.dashboard'))
@section('logout-url', route('peserta.logout'))
@section('pengguna', Auth::guard('peserta')->user()->nama)

@section('menu')
    <a href="{{ route('peserta.dashboard') }}"
        class="py-1 border-b-2 transition-colors {{ request()->routeIs('peserta.*') ? 'text-brand-amber border-brand-amber font-semibold' : 'text-slate-300 border-transparent hover:text-white' }}">Dashboard Saya</a>
@endsection