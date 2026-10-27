@extends('layouts.peserta')

@section('title', 'Pengajuan - Langkah 2')

@section('content')
    @php
        $pilihan = [
            'eksisting' => ['Inovasi Eksisting', '(sudah berjalan minimal 1 tahun)'],
            'pengembangan' => ['Pengembangan Inovasi', null],
            'rancangan' => ['Rancangan Inovasi', '(baru)'],
        ];
    @endphp

    <div class="max-w-3xl mx-auto">
        <p class="mb-4"><a href="{{ route('peserta.pengajuan.step1.edit', $pengajuan->uuid) }}" class="text-sm text-slate-500 hover:text-ink">← Kembali ke Langkah 1</a></p>

        @include('peserta.pengajuan._stepper', ['langkah' => 2])

        <h1 class="text-2xl font-bold">Bentuk Inovasi</h1>
        <p class="text-slate-500 mt-1 mb-5">{{ $pengajuan->nama_inovasi }} ({{ $pengajuan->akronim }})</p>

        @if ($errors->any())
            <div class="mb-5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm p-3">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('peserta.pengajuan.step2.submit', $pengajuan->uuid) }}" class="space-y-3">
            @csrf

            @foreach ($pilihan as $nilai => [$judul, $keterangan])
                <label class="flex items-start gap-3 bg-white border border-line rounded-2xl p-5 cursor-pointer transition-colors hover:border-brand-amber has-[:checked]:border-brand-amber has-[:checked]:bg-amber-50">
                    <input type="radio" name="bentuk_inovasi" value="{{ $nilai }}" required class="mt-1 accent-amber-500"
                        {{ old('bentuk_inovasi', $pengajuan->bentuk_inovasi) === $nilai ? 'checked' : '' }}>
                    <span class="font-medium">{{ $judul }} @if ($keterangan) <span class="block text-sm text-slate-500 font-normal">{{ $keterangan }}</span> @endif</span>
                </label>
            @endforeach

            <div class="flex justify-end pt-2">
                <button type="submit" class="bg-brand-amber hover:bg-brand-amber-dark text-brand-navy font-semibold rounded-xl px-8 py-3 transition-colors">
                    Lanjut ke Langkah 3
                </button>
            </div>
        </form>
    </div>
@endsection