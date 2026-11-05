@extends('layouts.pimpinan')

@section('title', 'Hasil Survei')

@section('content')
    <div class="max-w-3xl">
        <h1 class="text-2xl font-bold">Hasil Survei</h1>
        <p class="text-slate-500 mt-1 mb-6">Survei Kepuasan Penyelenggaraan &middot; Hanya-lihat.</p>

        @include('survei._hasil')
    </div>
@endsection