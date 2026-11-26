@extends('layouts.admin')

@section('title', 'Hasil Survei')

@section('content')
    <div class="max-w-3xl">
        <p class="mb-3"><a href="{{ route('admin.dashboard') }}" class="text-sm text-slate-500 hover:text-ink">← Dashboard</a></p>
        <h1 class="text-2xl font-bold">Hasil Survei</h1>
        <p class="text-slate-500 mt-1 mb-6">Survei Kepuasan Penyelenggaraan</p>

        @if (! empty($belumMigrasi))
            <div class="rounded-2xl bg-amber-50 border border-amber-200 text-amber-800 text-sm p-6">
                Tabel survei belum tersedia di database. Jalankan migrasi (<code>php artisan migrate</code>) di server terlebih dahulu.
            </div>
        @else
            @include('survei._hasil', ['tautanPartisipasi' => route('admin.survei.partisipasi')])
        @endif
    </div>
@endsection