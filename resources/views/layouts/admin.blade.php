@extends('layouts.app')

@section('peran', 'Administrator')
@section('lebar', 'max-w-7xl')
@section('jarak-menu', 'gap-x-3')
@section('beranda-url', route('admin.dashboard'))
@section('logout-url', route('admin.logout'))
@section('pengguna', Auth::guard('admin')->user()->nama)

@section('menu')
    @php
        $aktif = fn (...$pola) => request()->routeIs(...$pola)
            ? 'text-brand-amber border-brand-amber font-semibold'
            : 'text-slate-300 border-transparent hover:text-white hover:border-white/20';
    @endphp
    <a href="{{ route('admin.dashboard') }}" class="py-1.5 border-b-2 transition-all {{ $aktif('admin.dashboard', 'admin.koreksi.*') }}">Dashboard</a>
    <a href="{{ route('admin.pengajuan.index') }}" class="py-1.5 border-b-2 transition-all {{ $aktif('admin.pengajuan.*') }}">Pengajuan</a>
    <a href="{{ route('admin.laporan.index') }}" class="py-1.5 border-b-2 transition-all {{ $aktif('admin.laporan.*') }}">Laporan Nilai</a>
    <a href="{{ route('admin.survei.index') }}" class="py-1.5 border-b-2 transition-all {{ $aktif('admin.survei.*') }}">Hasil Survei</a>
    <a href="{{ route('admin.akun.panitia.index') }}" class="py-1.5 border-b-2 transition-all {{ $aktif('admin.akun.*') }}">Kelola Akun</a>
    <a href="{{ route('admin.jadwal.index') }}" class="py-1.5 border-b-2 transition-all {{ $aktif('admin.jadwal.*') }}">Jadwal</a>
    <a href="{{ route('admin.ranking.index') }}" class="py-1.5 border-b-2 transition-all {{ $aktif('admin.ranking.*') }}">Ranking</a>
    <a href="{{ route('admin.pengaturan.form') }}" class="py-1.5 border-b-2 transition-all {{ $aktif('admin.pengaturan.*') }}">Pengaturan</a>
@endsection
