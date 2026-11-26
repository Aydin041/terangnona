@extends('layouts.admin')

@section('title', 'Daftar Partisipasi Survei')

@section('content')
    <div class="max-w-3xl">
        <p class="mb-3"><a href="{{ route('admin.survei.index') }}" class="text-sm text-slate-500 hover:text-ink">← Hasil Survei</a></p>
        <h1 class="text-2xl font-bold">Daftar Partisipasi</h1>
        <p class="text-slate-500 mt-1 mb-6">Survei Kepuasan Penyelenggaraan &middot; hanya terlihat oleh Admin. Jawaban tidak ditampilkan di sini dan tidak bisa dikaitkan dengan nama.</p>

        @if (! empty($belumMigrasi))
            <div class="rounded-2xl bg-amber-50 border border-amber-200 text-amber-800 text-sm p-6">
                Tabel survei belum tersedia di database. Jalankan migrasi (<code>php artisan migrate</code>) di server terlebih dahulu.
            </div>
        @else

        <div class="bg-white border border-line rounded-2xl p-6 mb-4">
            <p class="text-sm text-slate-500">Sudah mengisi</p>
            <p class="mt-1"><span class="text-3xl font-bold">{{ $sudah->count() }}</span> <span class="text-sm text-slate-500">dari {{ $jumlahLayak }} peserta</span></p>
            <p class="text-xs text-slate-400 mt-2">Peserta yang dihitung adalah yang sedikitnya satu pengajuannya sudah disetujui atau ditolak.</p>
        </div>

        <h2 class="font-semibold mb-3">Sudah Mengisi</h2>
        <div class="bg-white border border-line rounded-2xl p-5 mb-6 text-sm">
            @if ($sudah->isEmpty())
                <span class="text-slate-500">Belum ada.</span>
            @else
                {{ $sudah->implode(', ') }}
            @endif
        </div>

        <h2 class="font-semibold mb-3">Belum Mengisi <span class="text-sm text-slate-400 font-normal">({{ $belum->count() }})</span></h2>
        <div class="bg-white border border-line rounded-2xl p-5 text-sm">
            @if ($belum->isEmpty())
                <span class="text-slate-500">Semua peserta sudah mengisi.</span>
            @else
                {{ $belum->implode(', ') }}
            @endif
        </div>
        @endif
    </div>
@endsection