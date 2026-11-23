@extends('layouts.admin')

@section('title', 'Jadwal Linimasa Kegiatan')

@section('content')
    @php
        $kelasInput = 'w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-ink placeholder-slate-400 bg-white transition-all focus:outline-none focus:ring-2 focus:ring-brand-amber/30 focus:border-brand-amber shadow-2xs';
    @endphp

    <div class="max-w-3xl">
        <div class="mb-8">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-ink tracking-tight">Manajemen Jadwal Kegiatan</h1>
            <p class="text-sm text-slate-500 mt-1 leading-relaxed">
                Kelola tanggal dan nama tahapan yang tampil di beranda utama publik. Status linimasa diperbarui otomatis oleh sistem berdasarkan tanggal kalender.
            </p>
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

        @if ($tahap->isEmpty())
            <div class="rounded-2xl bg-amber-50 border border-amber-200 text-amber-800 text-sm p-6">
                Jadwal belum tersimpan di database. Jalankan migrasi atau seeder terlebih dahulu.
            </div>
        @else
            <form method="POST" action="{{ route('admin.jadwal.update') }}" class="space-y-6">
                @csrf

                @foreach ($tahap as $i => $t)
                    <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-7 shadow-sm">
                        <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-100">
                            <div class="flex items-center gap-2">
                                <span class="w-6 h-6 rounded-lg bg-brand-navy text-brand-amber text-xs font-bold flex items-center justify-center">0{{ $i + 1 }}</span>
                                <h2 class="font-bold text-ink text-base">Tahap {{ $i + 1 }} &middot; {{ $t->kunci }}</h2>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label for="nama-{{ $t->id }}" class="block text-xs sm:text-sm font-bold text-ink mb-1.5">Nama Tahapan</label>
                                <input type="text" id="nama-{{ $t->id }}" name="tahap[{{ $t->id }}][nama]" required maxlength="200"
                                    value="{{ old('tahap.' . $t->id . '.nama', $t->nama) }}" class="{{ $kelasInput }}">
                            </div>

                            <div class="grid sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="mulai-{{ $t->id }}" class="block text-xs sm:text-sm font-bold text-ink mb-1.5">Tanggal Mulai</label>
                                    <input type="date" id="mulai-{{ $t->id }}" name="tahap[{{ $t->id }}][mulai]" required
                                        value="{{ old('tahap.' . $t->id . '.mulai', $t->mulai->format('Y-m-d')) }}" class="{{ $kelasInput }}">
                                </div>
                                <div>
                                    <label for="selesai-{{ $t->id }}" class="block text-xs sm:text-sm font-bold text-ink mb-1.5">Tanggal Selesai</label>
                                    <input type="date" id="selesai-{{ $t->id }}" name="tahap[{{ $t->id }}][selesai]" required
                                        value="{{ old('tahap.' . $t->id . '.selesai', $t->selesai->format('Y-m-d')) }}" class="{{ $kelasInput }}">
                                </div>
                            </div>

                            <div>
                                <label for="sorot-{{ $t->id }}" class="block text-xs sm:text-sm font-bold text-ink mb-1.5">Teks Ringkas di Kartu Hero Beranda</label>
                                <input type="text" id="sorot-{{ $t->id }}" name="tahap[{{ $t->id }}][sorot]" maxlength="60"
                                    placeholder="Contoh: Pendaftaran Proposal"
                                    value="{{ old('tahap.' . $t->id . '.sorot', $t->sorot) }}" class="{{ $kelasInput }}">
                                <p class="text-2xs sm:text-xs text-slate-400 mt-1">Kosongkan jika tahap ini tidak perlu disorot pada kartu depan.</p>
                            </div>

                            @if ($t->kunci === 'pendaftaran')
                                <div class="p-3 rounded-xl bg-amber-50 border border-amber-200/80 text-amber-800 text-xs">
                                    💡 <strong>Catatan:</strong> Batas penutupan pendaftaran sebenarnya mengikuti <em>"Deadline Pengajuan"</em> pada halaman Pengaturan Sistem jika diatur.
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach

                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/60 text-xs text-slate-500">
                    💡 Gunakan kode <code>{tahun}</code> pada kolom nama tahapan untuk digantikan otomatis dengan tahun periode berjalan.
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-brand-amber to-amber-500 hover:from-amber-400 hover:to-amber-500 text-brand-navy font-bold rounded-xl py-4 text-sm transition-all duration-200 shadow-md shadow-amber-500/15 active:scale-95">
                    Simpan Seluruh Jadwal Kegiatan
                </button>
            </form>
        @endif
    </div>
@endsection
