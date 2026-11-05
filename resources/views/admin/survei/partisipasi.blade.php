@extends('layouts.admin')

@section('title', 'Daftar Partisipasi Survei')

@section('content')
    <div class="max-w-3xl">
        <p class="mb-3"><a href="{{ route('admin.survei.index') }}" class="text-sm text-slate-500 hover:text-ink">← Hasil Survei</a></p>
        <h1 class="text-2xl font-bold">Daftar Partisipasi</h1>
        <p class="text-slate-500 mt-1 mb-6">Survei Kepuasan Penyelenggaraan &middot; hanya terlihat oleh Admin. Jawaban tidak ditampilkan di sini dan tidak bisa dikaitkan dengan nama.</p>

        <div class="bg-white border border-line rounded-2xl p-6 mb-4">
            <p class="text-sm text-slate-500">Sudah mengisi</p>
            <p class="mt-1"><span class="text-3xl font-bold">{{ $sudah->count() }}</span> <span class="text-sm text-slate-500">dari {{ $jumlahLayak }} peserta</span></p>
            <p class="text-xs text-slate-400 mt-2">Peserta yang dihitung adalah yang sudah mengirim sedikitnya satu pengajuan.</p>
        </div>

        <h2 class="font-semibold mb-3">Sudah Mengisi</h2>
        <div class="bg-white border border-line rounded-2xl p-5 mb-6 text-sm">
            @forelse ($sudah as $nama)
                <span class="inline-block mr-3 mb-1">{{ $nama }}</span>
            @empty
                <span class="text-slate-500">Belum ada.</span>
            @endforelse
        </div>

        <h2 class="font-semibold mb-3">Belum Mengisi <span class="text-sm text-slate-400 font-normal">({{ $belum->count() }})</span></h2>
        <div class="bg-white border border-line rounded-2xl p-5 text-sm">
            @forelse ($belum as $nama)
                <span class="inline-block mr-3 mb-1">{{ $nama }}</span>
            @empty
                <span class="text-slate-500">Semua peserta sudah mengisi.</span>
            @endforelse
        </div>
    </div>
@endsection