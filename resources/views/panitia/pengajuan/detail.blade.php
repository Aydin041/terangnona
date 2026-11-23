@extends('layouts.panitia')

@section('title', 'Detail Verifikasi Pengajuan')

@section('content')
    <a href="{{ route('panitia.pengajuan.index') }}" class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-semibold text-slate-500 hover:text-brand-navy transition-colors mb-6 group">
        <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali ke Daftar Pengajuan
    </a>

    <div class="flex items-start justify-between gap-4 flex-wrap mb-8">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-ink tracking-tight">Verifikasi Berkas Inovasi</h1>
            <p class="text-sm text-slate-500 mt-1">{{ $pengajuan->nama_inovasi }} <span class="font-medium">({{ $pengajuan->akronim }})</span></p>
        </div>
        <x-badge-status :status="$pengajuan->status" />
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

    <div class="space-y-6">
        {{-- Profil Inovasi --}}
        <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-8 shadow-sm">
            <h2 class="font-bold text-ink text-lg mb-4 pb-3 border-b border-slate-100">Profil Inovasi &amp; Pemohon</h2>
            <dl class="text-xs sm:text-sm divide-y divide-slate-100">
                <div class="flex flex-col sm:flex-row sm:gap-4 py-3"><dt class="text-slate-500 sm:w-48 shrink-0 font-medium">Nama Inovasi</dt><dd class="font-bold text-ink">{{ $pengajuan->nama_inovasi }} ({{ $pengajuan->akronim }})</dd></div>
                <div class="flex flex-col sm:flex-row sm:gap-4 py-3"><dt class="text-slate-500 sm:w-48 shrink-0 font-medium">Kategori</dt><dd class="text-ink">{{ $pengajuan->kategori->nama }}</dd></div>
                <div class="flex flex-col sm:flex-row sm:gap-4 py-3"><dt class="text-slate-500 sm:w-48 shrink-0 font-medium">Bentuk Inovasi</dt><dd class="text-ink"><span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-800 border border-amber-200">{{ $pengajuan->nama_bentuk }}</span></dd></div>
                <div class="flex flex-col sm:flex-row sm:gap-4 py-3"><dt class="text-slate-500 sm:w-48 shrink-0 font-medium">Inovator / Peserta</dt><dd class="text-ink font-semibold">{{ $pengajuan->peserta->nama }} &middot; <span class="text-slate-500 font-normal">{{ $pengajuan->peserta->email }} ({{ $pengajuan->peserta->kontak }})</span></dd></div>
                <div class="flex flex-col sm:flex-row sm:gap-4 py-3"><dt class="text-slate-500 sm:w-48 shrink-0 font-medium">Deskripsi Abstrak</dt><dd class="text-slate-600 leading-relaxed">{{ $pengajuan->deskripsi }}</dd></div>
            </dl>
        </div>

        {{-- Tim Inovator --}}
        <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-8 shadow-sm">
            <h2 class="font-bold text-ink text-lg mb-4 pb-3 border-b border-slate-100">Susunan Tim Inovator</h2>
            <ul class="text-xs sm:text-sm space-y-2">
                @foreach ($pengajuan->anggotaKelompok as $anggota)
                    <li class="flex items-center justify-between p-3.5 rounded-xl bg-slate-50 border border-slate-200/60">
                        <div>
                            <span class="font-bold text-ink">{{ $anggota->nama }}</span>
                            <span class="text-xs text-slate-500 ml-2">({{ $anggota->kontak }})</span>
                        </div>
                        @if ($anggota->adalah_ketua)
                            <span class="text-xs font-bold text-brand-navy bg-amber-200/70 rounded-md px-2 py-0.5">Ketua Tim</span>
                        @else
                            <span class="text-xs text-slate-400">Anggota</span>
                        @endif
                    </li>
                @endforeach
            </ul>

            @if (count($peringatanDuplikasi) > 0)
                <div class="mt-4 rounded-2xl bg-amber-50 border border-amber-300 p-4 text-xs sm:text-sm text-amber-900">
                    <strong class="font-bold block mb-1">⚠ Catatan Sistem: Ditemukan kemiripan nama dengan inovasi lain:</strong>
                    <ul class="list-disc list-inside space-y-0.5 text-slate-700">
                        @foreach ($peringatanDuplikasi as $pengajuanId => $info)
                            <li>{{ $info }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        {{-- Dokumen & Bukti Dukung --}}
        <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-8 shadow-sm">
            <h2 class="font-bold text-ink text-lg mb-4 pb-3 border-b border-slate-100">Dokumen Kelengkapan Berkas</h2>
            <ul class="text-xs sm:text-sm space-y-3">
                @forelse ($pengajuan->dokumen as $dok)
                    <li class="flex items-center justify-between p-4 rounded-2xl bg-slate-50/70 border border-slate-200/70 flex-wrap gap-2">
                        <div>
                            <span class="font-bold text-ink block sm:inline">{{ $dok->nama_jenis }}</span>
                            <span class="text-xs text-slate-400 sm:ml-2">({{ $dok->label }})</span>
                        </div>
                        <a href="{{ $dok->tautan }}" target="_blank" rel="noopener noreferrer"
                            class="inline-flex items-center gap-1.5 bg-brand-navy hover:bg-brand-navy-soft text-white text-xs font-semibold rounded-xl px-4 py-2 transition-colors shadow-2xs">
                            <span>Buka Dokumen</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </a>
                    </li>
                @empty
                    <li class="text-slate-400 italic p-4 text-center">Belum ada dokumen yang dilampirkan.</li>
                @endforelse
            </ul>
        </div>

        {{-- Form Aksi Verifikasi Panitia --}}
        @if ($pengajuan->status === 'menunggu_pemeriksaan')
            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-8 shadow-sm">
                <h2 class="font-bold text-ink text-lg mb-2">Tindakan Verifikasi Panitia</h2>
                <p class="text-xs sm:text-sm text-slate-500 mb-6">Pilih salah satu keputusan verifikasi di bawah ini.</p>

                {{-- Tombol Setujui --}}
                <div class="p-5 rounded-2xl bg-emerald-50/60 border border-emerald-200 mb-6 flex items-center justify-between gap-4 flex-wrap">
                    <div>
                        <h3 class="font-bold text-emerald-900 text-sm sm:text-base">Setujui Berkas Pengajuan</h3>
                        <p class="text-xs text-emerald-700 mt-0.5">Berkas dinyatakan lengkap dan sah untuk dinilai oleh Dewan Juri.</p>
                    </div>
                    <form method="POST" action="{{ route('panitia.pengajuan.setujui', $pengajuan->uuid) }}"
                        onsubmit="return confirm('Apakah Anda yakin menyetujui pengajuan ini? Data akan langsung diteruskan ke Dewan Juri.');">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl px-6 py-2.5 text-xs sm:text-sm transition-all shadow-md shadow-emerald-600/15 active:scale-95">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span>Setujui Pengajuan</span>
                        </button>
                    </form>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    {{-- Form Kembalikan untuk Revisi --}}
                    <div class="p-5 rounded-2xl bg-amber-50/50 border border-amber-200 flex flex-col justify-between">
                        <form method="POST" action="{{ route('panitia.pengajuan.kembalikan', $pengajuan->uuid) }}">
                            @csrf
                            <h3 class="font-bold text-amber-900 text-sm mb-1">Kembalikan untuk Perbaikan</h3>
                            <p class="text-xs text-amber-800 mb-3">Peserta akan menerima catatan perbaikan dan dapat mengedit ulang berkasnya.</p>
                            <label class="block text-xs font-bold text-ink mb-1.5">Catatan Revisi / Dokumen Kurang:</label>
                            <textarea name="catatan_panitia" rows="3" required placeholder="Tuliskan bagian mana yang perlu diperbaiki peserta..."
                                class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-xs sm:text-sm text-ink placeholder-slate-400 bg-white transition-all focus:outline-none focus:ring-2 focus:ring-brand-amber/30 focus:border-brand-amber shadow-2xs">{{ old('catatan_panitia') }}</textarea>
                            <button type="submit" class="mt-3 w-full bg-white hover:bg-amber-100/60 text-amber-900 border border-amber-300 font-bold rounded-xl px-5 py-2.5 text-xs sm:text-sm transition-colors shadow-2xs">
                                Kembalikan ke Peserta
                            </button>
                        </form>
                    </div>

                    {{-- Form Tolak Pengajuan --}}
                    <div class="p-5 rounded-2xl bg-rose-50/50 border border-rose-200 flex flex-col justify-between">
                        <form method="POST" action="{{ route('panitia.pengajuan.tolak', $pengajuan->uuid) }}"
                            onsubmit="return confirm('Yakin mau tolak pengajuan ini? Peserta TIDAK bisa mengedit lagi setelah ditolak.');">
                            @csrf
                            <h3 class="font-bold text-rose-900 text-sm mb-1">Tolak Pengajuan (Permanen)</h3>
                            <p class="text-xs text-rose-800 mb-3">Gunakan jika pengajuan tidak memenuhi kriteria dasar atau terbukti plagiarisme.</p>
                            <label class="block text-xs font-bold text-ink mb-1.5">Alasan Penolakan Resmi:</label>
                            <textarea name="catatan_panitia" rows="3" required placeholder="Tuliskan alasan penolakan..."
                                class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-xs sm:text-sm text-ink placeholder-slate-400 bg-white transition-all focus:outline-none focus:ring-2 focus:ring-rose-500/30 focus:border-rose-500 shadow-2xs">{{ old('catatan_panitia') }}</textarea>
                            <button type="submit" class="mt-3 w-full bg-rose-600 hover:bg-rose-700 text-white font-bold rounded-xl px-5 py-2.5 text-xs sm:text-sm transition-colors shadow-sm">
                                Tolak Pengajuan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white border border-slate-200/80 rounded-2xl p-5 text-center text-xs sm:text-sm text-slate-500 shadow-sm">
                Pengajuan ini telah diproses dengan status <strong class="text-ink font-semibold">{{ $pengajuan->status }}</strong>. Tidak ada tindakan verifikasi yang diperlukan saat ini.
            </div>
        @endif
    </div>
@endsection
