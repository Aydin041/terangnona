@extends('layouts.admin')

@section('title', 'Pengaturan Sistem')

@section('content')
    <div class="max-w-2xl">
        <div class="mb-8">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-ink tracking-tight">Pengaturan Sistem</h1>
            <p class="text-sm text-slate-500 mt-1">Konfigurasi batas waktu pengajuan, kuorum submit juri, dan jadwal survei kepuasan.</p>
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

        @if (session('sukses'))
            <div class="mb-6 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm p-4 font-medium">
                {{ session('sukses') }}
            </div>
        @endif

        @php
            $kelasInput = 'w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-ink placeholder-slate-400 bg-white transition-all focus:outline-none focus:ring-2 focus:ring-brand-amber/30 focus:border-brand-amber shadow-2xs';
        @endphp

        <form method="POST" action="{{ route('admin.pengaturan.update') }}" class="space-y-6">
            @csrf

            {{-- Deadline Pengajuan --}}
            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-7 shadow-sm">
                <div class="flex items-center gap-2 mb-1">
                    <span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span>
                    <h2 class="font-bold text-ink text-base">Batas Waktu (Deadline) Pengajuan Baru</h2>
                </div>
                <p class="text-xs sm:text-sm text-slate-500 mb-4 leading-relaxed">
                    Setelah melewati tanggal ini, tombol buat pengajuan baru ditutup untuk peserta (pengajuan lama berstatus revisi tetap dapat diedit).
                </p>

                <input type="datetime-local" name="deadline_pengajuan"
                    value="{{ old('deadline_pengajuan', optional($pengaturan->deadline_pengajuan)->format('Y-m-d\TH:i')) }}"
                    class="{{ $kelasInput }}">
                <p class="text-2xs sm:text-xs text-slate-400 mt-2">Kosongkan kolom lalu klik simpan jika ingin membuka pendaftaran tanpa batas waktu.</p>
            </div>

            {{-- Kuorum Juri --}}
            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-7 shadow-sm">
                <div class="flex items-center gap-2 mb-1">
                    <span class="w-2.5 h-2.5 rounded-full bg-brand-blue"></span>
                    <h2 class="font-bold text-ink text-base">Kuorum Penilaian Dewan Juri</h2>
                </div>
                <p class="text-xs sm:text-sm text-slate-500 mb-4 leading-relaxed">
                    Jumlah minimum dewan juri yang wajib submit nilai sebelum skor rata-rata tampil di tabel klasemen/ranking.
                </p>

                <label for="minimal_juri_submit" class="block text-xs sm:text-sm font-bold text-ink mb-1.5">Minimal Juri Submit Final:</label>
                <input type="number" id="minimal_juri_submit" name="minimal_juri_submit" min="1" max="{{ max(1, $jumlahJuri) }}" required
                    value="{{ old('minimal_juri_submit', $pengaturan->minimal_juri_submit ?? 2) }}"
                    class="{{ $kelasInput }}">
                <div class="flex items-center justify-between mt-2 text-2xs sm:text-xs">
                    <span class="text-slate-400">Total akun juri aktif saat ini: <strong class="text-ink font-semibold">{{ $jumlahJuri }} orang</strong></span>
                    <span class="text-amber-700 font-medium">Ubah sebelum penilaian dimulai</span>
                </div>
            </div>

            {{-- Jadwal Survei --}}
            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-7 shadow-sm">
                <div class="flex items-center gap-2 mb-1">
                    <span class="w-2.5 h-2.5 rounded-full bg-brand-amber"></span>
                    <h2 class="font-bold text-ink text-base">Periode Survei Kepuasan</h2>
                </div>
                <p class="text-xs sm:text-sm text-slate-500 mb-4 leading-relaxed">
                    Rentang waktu formulir survei evaluasi dapat diisi oleh inovator peserta di dashboard.
                </p>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label for="survei_dibuka_pada" class="block text-xs sm:text-sm font-bold text-ink mb-1.5">Survei Dibuka</label>
                        <input type="datetime-local" id="survei_dibuka_pada" name="survei_dibuka_pada"
                            value="{{ old('survei_dibuka_pada', optional($pengaturan->survei_dibuka_pada)->format('Y-m-d\TH:i')) }}"
                            class="{{ $kelasInput }}">
                    </div>

                    <div>
                        <label for="survei_ditutup_pada" class="block text-xs sm:text-sm font-bold text-ink mb-1.5">Survei Ditutup</label>
                        <input type="datetime-local" id="survei_ditutup_pada" name="survei_ditutup_pada"
                            value="{{ old('survei_ditutup_pada', optional($pengaturan->survei_ditutup_pada)->format('Y-m-d\TH:i')) }}"
                            class="{{ $kelasInput }}">
                    </div>
                </div>

                <p class="text-2xs sm:text-xs text-slate-400 mt-3">{{ $petunjukSurvei }}</p>
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-brand-amber to-amber-500 hover:from-amber-400 hover:to-amber-500 text-brand-navy font-bold rounded-xl py-3.5 text-sm transition-all duration-200 shadow-md shadow-amber-500/15 active:scale-95">
                Simpan Perubahan Pengaturan
            </button>
        </form>

        {{-- Ganti Password Admin --}}
        <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-7 shadow-sm mt-6 flex items-center justify-between gap-4 flex-wrap">
            <div>
                <h3 class="font-bold text-ink text-base">Keamanan Akun Administrator</h3>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Perbarui kata sandi akun login Anda secara berkala.</p>
            </div>
            <a href="{{ route('admin.kata-sandi.form') }}" class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-bold text-brand-blue bg-blue-50 border border-blue-200/70 rounded-xl px-4 py-2 hover:bg-blue-100/60 transition-colors">
                <span>Ubah Sandi</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>
@endsection
