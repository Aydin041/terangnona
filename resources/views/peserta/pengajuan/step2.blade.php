@extends('layouts.peserta')

@section('title', 'Pengajuan - Langkah 2')

@section('content')
    @php
        $pilihan = [
            'eksisting' => ['Inovasi Eksisting', 'Inovasi sudah diimplementasikan dan berjalan minimal 1 tahun'],
            'pengembangan' => ['Pengembangan Inovasi', 'Pengembangan atau peningkatan dari inovasi yang sudah ada sebelumnya'],
            'rancangan' => ['Rancangan Inovasi', 'Gagasan atau inisiatif terobosan baru yang siap diimplementasikan'],
        ];
    @endphp

    <div class="max-w-3xl mx-auto">
        <a href="{{ route('peserta.pengajuan.step1.edit', $pengajuan->uuid) }}" class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-semibold text-slate-500 hover:text-brand-navy transition-colors mb-6 group">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Langkah 1
        </a>

        @include('peserta.pengajuan._stepper', ['langkah' => 2])

        <div class="mb-6">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-ink tracking-tight">Bentuk Inovasi</h1>
            <p class="text-sm text-slate-500 mt-1">{{ $pengajuan->nama_inovasi }} <span class="font-medium">({{ $pengajuan->akronim }})</span></p>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-2xl bg-red-50/80 border border-red-200 text-red-700 text-xs sm:text-sm p-4">
                <ul class="list-disc list-inside space-y-1 font-medium">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('peserta.pengajuan.step2.submit', $pengajuan->uuid) }}" class="space-y-4">
            @csrf

            <div class="space-y-3">
                @foreach ($pilihan as $nilai => [$judul, $keterangan])
                    <label class="flex items-start gap-4 bg-white border border-slate-200/80 rounded-2xl p-5 sm:p-6 cursor-pointer transition-all hover:border-brand-amber hover:shadow-sm has-[:checked]:border-brand-amber has-[:checked]:bg-amber-50/40 has-[:checked]:ring-2 has-[:checked]:ring-brand-amber/20 group">
                        <input type="radio" name="bentuk_inovasi" value="{{ $nilai }}" required class="mt-1 accent-brand-amber w-4 h-4"
                            {{ old('bentuk_inovasi', $pengajuan->bentuk_inovasi) === $nilai ? 'checked' : '' }}>
                        <div class="flex-1">
                            <span class="font-bold text-base text-ink block group-hover:text-brand-navy">{{ $judul }}</span>
                            @if ($keterangan)
                                <span class="block text-xs sm:text-sm text-slate-500 mt-1 leading-relaxed">{{ $keterangan }}</span>
                            @endif
                        </div>
                    </label>
                @endforeach
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="inline-flex items-center gap-2 bg-gradient-to-r from-brand-amber to-amber-500 hover:from-amber-400 hover:to-amber-500 text-brand-navy font-bold rounded-xl px-7 py-3.5 text-sm transition-all duration-200 shadow-md shadow-amber-500/15 active:scale-95">
                    <span>Lanjut ke Langkah 3</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </div>
        </form>
    </div>
@endsection
