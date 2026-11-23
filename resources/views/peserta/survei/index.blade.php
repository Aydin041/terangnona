@extends('layouts.peserta')

@section('title', 'Survei Kepuasan Penyelenggaraan')

@section('content')
    @php
        $tahunSurvei = \App\Models\TahapJadwal::tahun();
        $format = fn ($waktu) => $waktu->copy()->locale('id')->translatedFormat('j F Y, H.i') . ' WIB';
    @endphp

    <div class="max-w-3xl mx-auto">
        <a href="{{ route('peserta.dashboard') }}" class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-semibold text-slate-500 hover:text-brand-navy transition-colors mb-6 group">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Dashboard Saya
        </a>

        @if (session('sukses'))
            <div class="mb-6 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm p-4 font-medium">
                {{ session('sukses') }}
            </div>
        @endif

        @if (! $layak)
            <div class="bg-white border border-slate-200/80 rounded-3xl p-10 text-center shadow-sm">
                <div class="w-14 h-14 rounded-2xl bg-amber-50 text-brand-amber-dark flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h2 class="text-xl font-bold text-ink mb-1">Survei Belum Tersedia</h2>
                <p class="text-xs sm:text-sm text-slate-500 max-w-md mx-auto leading-relaxed">
                    Survei evaluasi hanya dapat diisi oleh peserta yang berkas pengajuannya sudah diputuskan (disetujui atau ditolak) oleh Panitia.
                </p>
            </div>
        @elseif ($sudahMengisi)
            <div class="bg-white border border-slate-200/80 rounded-3xl p-10 text-center shadow-sm">
                <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                </div>
                <h2 class="text-xl font-bold text-ink mb-1">Terima Kasih Banyak!</h2>
                <p class="text-xs sm:text-sm text-slate-500 max-w-md mx-auto leading-relaxed">
                    Anda sudah mengisi survei kepuasan. Masukan Anda sangat berharga bagi peningkatan mutu penyelenggaraan TERANG NONA ke depan.
                </p>
            </div>
        @elseif ($status === 'tidak_aktif' || $status === 'belum_dibuka')
            <div class="bg-white border border-slate-200/80 rounded-3xl p-10 text-center shadow-sm">
                <div class="w-14 h-14 rounded-2xl bg-slate-50 text-slate-400 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h2 class="text-xl font-bold text-ink mb-1">Survei Belum Dibuka</h2>
                @if ($dibuka && $ditutup)
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">
                        Jadwal survei: <strong class="text-ink">{{ $format($dibuka) }}</strong> sampai <strong class="text-ink">{{ $format($ditutup) }}</strong>.
                    </p>
                @endif
            </div>
        @elseif ($status === 'ditutup')
            <div class="bg-white border border-slate-200/80 rounded-3xl p-10 text-center shadow-sm">
                <div class="w-14 h-14 rounded-2xl bg-slate-50 text-slate-400 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                </div>
                <h2 class="text-xl font-bold text-ink mb-1">Periode Survei Telah Berakhir</h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">Terima kasih atas partisipasi dan kontribusi ide Anda.</p>
            </div>
        @else
            <div class="mb-6">
                <h1 class="text-2xl sm:text-3xl font-extrabold text-ink tracking-tight">Survei Kepuasan Penyelenggaraan</h1>
                <p class="text-sm text-slate-500 mt-1">Berikan penilaian Anda atas mutu penyelenggaraan TERANG NONA {{ $tahunSurvei }}.</p>
                <p class="text-xs text-slate-400 mt-0.5">Seluruh masukan diperlakukan secara rahasia dan bersifat anonim.</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 rounded-2xl bg-red-50/80 border border-red-200 text-red-700 text-xs sm:text-sm p-4 font-medium">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('peserta.survei.kirim') }}" class="space-y-6">
                @csrf

                {{-- Pertanyaan 1 --}}
                <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-8 shadow-sm">
                    <h2 class="font-bold text-ink text-sm sm:text-base mb-1">
                        1. Seberapa baik penyelenggaraan kompetisi TERANG NONA {{ $tahunSurvei }}? <span class="text-rose-500">*</span>
                    </h2>
                    <p class="text-xs text-slate-400 mb-5">Pilih skor dari 1 (Sangat Kurang) hingga 5 (Sangat Baik)</p>

                    <div class="flex items-center gap-3 flex-wrap">
                        @for ($i = 1; $i <= 5; $i++)
                            <label class="flex-1 min-w-[50px] cursor-pointer">
                                <input type="radio" name="kepuasan" value="{{ $i }}" required class="sr-only peer"
                                    {{ old('kepuasan') == $i ? 'checked' : '' }}>
                                <div class="text-center py-3.5 rounded-2xl border border-slate-200 bg-white hover:bg-slate-50 text-ink font-black text-lg transition-all peer-checked:bg-brand-navy peer-checked:text-brand-amber peer-checked:border-brand-navy peer-checked:shadow-md peer-checked:scale-105">
                                    {{ $i }}
                                </div>
                            </label>
                        @endfor
                    </div>
                    <div class="flex justify-between text-2xs text-slate-400 font-semibold uppercase tracking-wider mt-2 px-1">
                        <span>Kurang Baik (1)</span>
                        <span>Sangat Baik (5)</span>
                    </div>
                </div>

                {{-- Pertanyaan 2 --}}
                <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-8 shadow-sm">
                    <h2 class="font-bold text-ink text-sm sm:text-base mb-1">
                        2. Aspek apa saja yang perlu ditingkatkan di masa depan?
                    </h2>
                    <p class="text-xs text-slate-400 mb-5">Boleh mencentang lebih dari satu pilihan</p>

                    @php
                        $opsiAspek = [
                            'Sosialisasi & Informasi Awal',
                            'Format Proposal & Panduan Teknis',
                            'Kemudahan Sistem Pendaftaran Web',
                            'Proses Pemeriksaan & Verifikasi Panitia',
                            'Komunikasi & Respon Panitia',
                            'Jadwal & Ketepatan Linimasa',
                        ];
                    @endphp

                    <div class="space-y-2.5">
                        @foreach ($opsiAspek as $aspek)
                            <label class="flex items-center gap-3 p-3.5 rounded-2xl border border-slate-200/80 hover:bg-slate-50 cursor-pointer transition-all has-[:checked]:bg-amber-50/50 has-[:checked]:border-brand-amber">
                                <input type="checkbox" name="aspek[]" value="{{ $aspek }}" class="accent-brand-amber w-4 h-4 rounded"
                                    {{ is_array(old('aspek')) && in_array($aspek, old('aspek')) ? 'checked' : '' }}>
                                <span class="text-xs sm:text-sm font-semibold text-ink">{{ $aspek }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Pertanyaan 3 --}}
                <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-8 shadow-sm">
                    <h2 class="font-bold text-ink text-sm sm:text-base mb-1">
                        3. Tuliskan saran dan masukan bebas Anda:
                    </h2>
                    <p class="text-xs text-slate-400 mb-4">Gagasan atau catatan konstruktif untuk panitia</p>

                    <textarea name="saran" rows="4" placeholder="Tuliskan pengalaman, kendala, atau saran pengembangan Anda..."
                        class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm text-ink placeholder-slate-400 bg-white transition-all focus:outline-none focus:ring-2 focus:ring-brand-amber/30 focus:border-brand-amber shadow-2xs">{{ old('saran') }}</textarea>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit" class="inline-flex items-center gap-2 bg-gradient-to-r from-brand-amber to-amber-500 hover:from-amber-400 hover:to-amber-500 text-brand-navy font-bold rounded-xl px-8 py-4 text-sm transition-all duration-200 shadow-md shadow-amber-500/15 active:scale-95">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        <span>Kirim Masukan Survei</span>
                    </button>
                </div>
            </form>
        @endif
    </div>
@endsection
