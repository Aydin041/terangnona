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
            @if (($jumlahPerbaikanProposal ?? 0) > 0)
                <span class="inline-block mt-3 text-xs font-semibold rounded-full bg-amber-100 text-amber-800 px-2.5 py-1">
                    {{ $jumlahPerbaikanProposal }} pengajuan perlu perbaikan
                </span>
            @endif
            @if (($jumlahDitolakProposal ?? 0) > 0)
                <span class="inline-block mt-3 text-xs font-semibold rounded-full bg-red-50 text-red-700 px-2.5 py-1">
                    {{ $jumlahDitolakProposal }} koreksi ditolak Admin
                </span>
            @endif
        </a>
        <a href="{{ route('juri.penilaian.daftar.presentasi') }}"
            class="block bg-white border border-line rounded-2xl p-6 hover:border-brand-amber transition-colors">
            <h2 class="font-semibold">Penilaian Presentasi</h2>
            <p class="text-sm text-slate-500 mt-1">Khusus pengajuan yang lolos 5 besar</p>
            @if (($jumlahPerbaikanPresentasi ?? 0) > 0)
                <span class="inline-block mt-3 text-xs font-semibold rounded-full bg-amber-100 text-amber-800 px-2.5 py-1">
                    {{ $jumlahPerbaikanPresentasi }} pengajuan perlu perbaikan
                </span>
            @endif
            @if (($jumlahDitolakPresentasi ?? 0) > 0)
                <span class="inline-block mt-3 text-xs font-semibold rounded-full bg-red-50 text-red-700 px-2.5 py-1">
                    {{ $jumlahDitolakPresentasi }} koreksi ditolak Admin
                </span>
            @endif
        </a>
    </div>
@endsection