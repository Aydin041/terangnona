{{-- Parameter: $judul, $nama, $sub (opsional), $ringkasan (array label => jumlah), $action, $batal --}}
@extends('layouts.admin')

@section('title', $judul)

@section('content')
    <div class="max-w-xl mx-auto">
        <h1 class="text-2xl font-bold">{{ $judul }}</h1>

        <div class="mt-5 rounded-2xl bg-red-50 border border-red-200 p-5 text-sm text-red-800">
            <p class="font-semibold">Tindakan ini permanen dan tidak bisa dibatalkan.</p>
            <p class="mt-1">Yang akan dihapus: <strong class="break-words">{{ $nama }}</strong></p>
            @isset($sub)
                <p class="text-red-700 break-words">{{ $sub }}</p>
            @endisset

            @if (count($ringkasan))
                <p class="mt-3 font-semibold">Data berikut ikut terhapus:</p>
                <ul class="list-disc list-inside mt-1 space-y-0.5">
                    @foreach ($ringkasan as $label => $jumlah)
                        <li>{{ $label }}: {{ $jumlah }}</li>
                    @endforeach
                </ul>
            @else
                <p class="mt-3">Tidak ada data turunan yang ikut terhapus.</p>
            @endif

            <p class="mt-3">Ranking, laporan nilai, dan ekspor Excel akan dihitung ulang tanpa data ini.</p>
        </div>

        @if ($errors->any())
            <div class="mt-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm p-3">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ $action }}" class="mt-5 bg-white border border-line rounded-2xl p-5 space-y-4">
            @csrf
            <div>
                <label for="konfirmasi" class="block text-sm font-medium mb-1">Ketik <code class="font-bold">HAPUS</code> untuk melanjutkan</label>
                <input id="konfirmasi" name="konfirmasi" type="text" autocomplete="off" required
                    class="w-full border border-line rounded-xl px-4 py-2.5 focus:outline-none focus:border-brand-amber">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl px-5 py-2.5 transition-colors">
                    Hapus Permanen
                </button>
                <a href="{{ $batal }}" class="font-medium border border-line hover:border-brand-amber rounded-xl px-5 py-2.5 transition-colors">Batal</a>
            </div>
        </form>
    </div>
@endsection