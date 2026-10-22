@extends('layouts.app')

@section('peran', 'Juri')
@section('beranda-url', route('juri.dashboard'))
@section('logout-url', route('juri.logout'))
@section('pengguna', Auth::guard('juri')->user()->nama)

@section('menu')
    @php
        $aktif = fn (...$pola) => request()->routeIs(...$pola)
            ? 'text-brand-amber border-brand-amber font-semibold'
            : 'text-slate-300 border-transparent hover:text-white';
    @endphp
    <a href="{{ route('juri.penilaian.index') }}" class="py-1 border-b-2 transition-colors {{ $aktif('juri.dashboard', 'juri.penilaian.index') }}">Beranda</a>
    <a href="{{ route('juri.penilaian.daftar.proposal') }}" class="py-1 border-b-2 transition-colors {{ $aktif('juri.penilaian.daftar.proposal', 'juri.penilaian.proposal*', 'juri.koreksi.proposal.*') }}">Penilaian Proposal</a>
    <a href="{{ route('juri.penilaian.daftar.presentasi') }}" class="py-1 border-b-2 transition-colors {{ $aktif('juri.penilaian.daftar.presentasi', 'juri.penilaian.presentasi*', 'juri.koreksi.presentasi.*') }}">Penilaian Presentasi</a>
@endsection