@extends('layouts.peserta')

@section('title', 'Pengajuan - Langkah 1')

@section('content')
    @php
        $kelasInput = 'w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-ink placeholder-slate-400 bg-white transition-all focus:outline-none focus:ring-2 focus:ring-brand-amber/30 focus:border-brand-amber shadow-2xs';
    @endphp

    <div class="max-w-3xl mx-auto">
        <a href="{{ route('peserta.dashboard') }}" class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-semibold text-slate-500 hover:text-brand-navy transition-colors mb-6 group">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Dashboard Saya
        </a>

        @include('peserta.pengajuan._stepper', ['langkah' => 1])

        <div class="mb-6">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-ink tracking-tight">{{ $pengajuan ? 'Perbaiki Pengajuan' : 'Pengajuan Baru' }}</h1>
            <p class="text-sm text-slate-500 mt-1">Langkah 1: Lengkapi profil identitas inovasi yang Anda ajukan.</p>
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

        <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-9 shadow-sm">
            <form method="POST" action="{{ $pengajuan ? route('peserta.pengajuan.step1.update', $pengajuan->uuid) : route('peserta.pengajuan.step1.submit') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="nama_inovasi" class="block text-xs sm:text-sm font-bold text-ink mb-1.5">Nama Inovasi</label>
                    <input type="text" id="nama_inovasi" name="nama_inovasi" value="{{ old('nama_inovasi', $pengajuan->nama_inovasi ?? '') }}" required placeholder="Contoh: Sistem Informasi Ketenagakerjaan Terpadu" class="{{ $kelasInput }}">
                </div>

                <div>
                    <label for="akronim" class="block text-xs sm:text-sm font-bold text-ink mb-1.5">Akronim / Nama Singkat</label>
                    <input type="text" id="akronim" name="akronim" value="{{ old('akronim', $pengajuan->akronim ?? '') }}" placeholder="Contoh: PANDU GUNUNG / SIK3" required class="{{ $kelasInput }}">
                </div>

                <div>
                    <label for="deskripsi" class="block text-xs sm:text-sm font-bold text-ink mb-1.5">Deskripsi Singkat (Abstrak Inovasi)</label>
                    <textarea id="deskripsi" name="deskripsi" rows="4" required placeholder="Jelaskan secara ringkas latar belakang dan terobosan inovasi..." class="{{ $kelasInput }}">{{ old('deskripsi', $pengajuan->deskripsi ?? '') }}</textarea>
                </div>

                <div>
                    <span class="block text-xs sm:text-sm font-bold text-ink mb-2">Jenis Inovasi</span>
                    <div class="grid sm:grid-cols-2 gap-3">
                        <label class="flex items-center gap-3 p-4 rounded-2xl border border-slate-200 bg-white hover:bg-slate-50 cursor-pointer transition-all has-[:checked]:border-brand-amber has-[:checked]:bg-amber-50/50 has-[:checked]:ring-1 has-[:checked]:ring-brand-amber">
                            <input type="radio" name="jenis_inovasi" value="digital" class="accent-brand-amber" required
                                {{ old('jenis_inovasi', $pengajuan->jenis_inovasi ?? '') === 'digital' ? 'checked' : '' }}>
                            <div>
                                <span class="font-bold text-sm text-ink block">Inovasi Digital</span>
                                <span class="text-xs text-slate-500">Aplikasi, web, sistem berbasis TI/IoT</span>
                            </div>
                        </label>
                        <label class="flex items-center gap-3 p-4 rounded-2xl border border-slate-200 bg-white hover:bg-slate-50 cursor-pointer transition-all has-[:checked]:border-brand-amber has-[:checked]:bg-amber-50/50 has-[:checked]:ring-1 has-[:checked]:ring-brand-amber">
                            <input type="radio" name="jenis_inovasi" value="non_digital" class="accent-brand-amber" required
                                {{ old('jenis_inovasi', $pengajuan->jenis_inovasi ?? '') === 'non_digital' ? 'checked' : '' }}>
                            <div>
                                <span class="font-bold text-sm text-ink block">Inovasi Non-Digital</span>
                                <span class="text-xs text-slate-500">Metode, SOP, rekayasa sosial/pelayanan</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label for="kategori_id" class="block text-xs sm:text-sm font-bold text-ink mb-1.5">Kategori Inovasi</label>
                        <select id="kategori_id" name="kategori_id" required class="{{ $kelasInput }}">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($kategoriList as $kategori)
                                <option value="{{ $kategori->id }}" {{ old('kategori_id', $pengajuan->kategori_id ?? '') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="unit_kerja_id" class="block text-xs sm:text-sm font-bold text-ink mb-1.5">Unit Kerja Pengampu</label>
                        <select id="unit_kerja_id" name="unit_kerja_id" required class="{{ $kelasInput }}">
                            <option value="">-- Pilih Unit Kerja --</option>
                            @foreach ($unitKerjaList as $unit)
                                <option value="{{ $unit->id }}" {{ old('unit_kerja_id', $pengajuan->unit_kerja_id ?? '') == $unit->id ? 'selected' : '' }}>
                                    {{ $unit->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label for="tahun_implementasi" class="block text-xs sm:text-sm font-bold text-ink mb-1.5">Tahun Implementasi / Rencana</label>
                    <input type="number" id="tahun_implementasi" name="tahun_implementasi" value="{{ old('tahun_implementasi', $pengajuan->tahun_implementasi ?? now()->year) }}" min="{{ now()->year - 20 }}" max="{{ now()->year + 5 }}" required
                        oninvalid="this.setCustomValidity('Isi dengan tahun {{ now()->year - 20 }} sampai {{ now()->year + 5 }}.')"
                        oninput="this.setCustomValidity('')"
                        class="{{ $kelasInput }}">
                    <p class="text-xs text-slate-400 mt-1.5">Rentang tahun valid: {{ now()->year - 20 }} sampai {{ now()->year + 5 }}.</p>
                </div>

                <div class="flex justify-end pt-4 border-t border-slate-100">
                    <button type="submit" class="inline-flex items-center gap-2 bg-gradient-to-r from-brand-amber to-amber-500 hover:from-amber-400 hover:to-amber-500 text-brand-navy font-bold rounded-xl px-7 py-3.5 text-sm transition-all duration-200 shadow-md shadow-amber-500/15 active:scale-95">
                        <span>Lanjut ke Langkah 2</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
