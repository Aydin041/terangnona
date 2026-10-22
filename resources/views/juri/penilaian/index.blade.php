@extends('layouts.juri')

@section('title', 'Daftar Penilaian')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Daftar Penilaian</h1>

    @if (session('sukses'))
        <div class="mb-5 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm p-3">
            {{ session('sukses') }}
        </div>
    @endif

    <div class="grid sm:grid-cols-2 gap-4">
        <a href="{{ route('juri.penilaian.daftar.proposal') }}"
            class="block bg-white border border-line rounded-2xl p-6 hover:border-brand-amber transition-colors">
            <h2 class="font-semibold">Penilaian Proposal</h2>
            <p class="text-sm text-slate-500 mt-1">Semua pengajuan yang disetujui Panitia</p>
        </a>
        <a href="{{ route('juri.penilaian.daftar.presentasi') }}"
            class="block bg-white border border-line rounded-2xl p-6 hover:border-brand-amber transition-colors">
            <h2 class="font-semibold">Penilaian Presentasi</h2>
            <p class="text-sm text-slate-500 mt-1">Khusus pengajuan yang lolos 5 besar</p>
        </a>
    </div>
@endsection