@extends('layouts.peserta')

@section('title', 'Pengajuan - Langkah 5 (Review & Submit)')

@section('content')
    @php
        $namaBentuk = [
            'eksisting' => 'Inovasi Eksisting',
            'pengembangan' => 'Pengembangan Inovasi',
            'rancangan' => 'Rancangan Inovasi',
        ];
        $namaDokumen = [
            'surat_identitas' => 'Surat Pernyataan Identitas Inovator',
            'surat_implementasi' => 'Surat Pernyataan Implementasi Inovasi',
            'surat_komitmen' => 'Surat Pernyataan Komitmen Implementasi Inovasi',
            'video_link' => 'Video Dampak Inovasi',
            'lampiran_rab' => 'Dokumen Rencana Anggaran Biaya (RAB)',
            'lampiran_rencana_aksi' => 'Lampiran Rencana Aksi/Pengembangan',
        ];
    @endphp

    <div class="max-w-3xl mx-auto">
        <a href="{{ route('peserta.pengajuan.step4', $pengajuan->uuid) }}" class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-semibold text-slate-500 hover:text-brand-navy transition-colors mb-6 group">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Langkah 4
        </a>

        @include('peserta.pengajuan._stepper', ['langkah' => 5])

        <div class="mb-6">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-ink tracking-tight">Review &amp; Kirim Pengajuan</h1>
            <p class="text-sm text-slate-500 mt-1">Periksa kembali kelengkapan seluruh data sebelum mengirim pengajuan ke Panitia.</p>
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

        <div class="space-y-5">
            {{-- Bagian Profil --}}
            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-7 shadow-sm">
                <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-100">
                    <h2 class="font-bold text-ink text-base">Profil Inovasi</h2>
                    <a href="{{ route('peserta.pengajuan.step1.edit', $pengajuan->uuid) }}" class="text-xs font-bold text-brand-blue hover:underline">Edit</a>
                </div>
                <dl class="text-sm divide-y divide-slate-100">
                    <div class="flex flex-col sm:flex-row sm:gap-4 py-2.5"><dt class="text-slate-500 sm:w-48 shrink-0 font-medium">Nama Inovasi</dt><dd class="font-bold text-ink">{{ $pengajuan->nama_inovasi }} ({{ $pengajuan->akronim }})</dd></div>
                    <div class="flex flex-col sm:flex-row sm:gap-4 py-2.5"><dt class="text-slate-500 sm:w-48 shrink-0 font-medium">Kategori</dt><dd class="text-ink">{{ $pengajuan->kategori->nama }}</dd></div>
                    <div class="flex flex-col sm:flex-row sm:gap-4 py-2.5"><dt class="text-slate-500 sm:w-48 shrink-0 font-medium">Bentuk Inovasi</dt><dd class="text-ink"><span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-800 border border-amber-200">{{ $namaBentuk[$pengajuan->bentuk_inovasi] ?? $pengajuan->bentuk_inovasi }}</span></dd></div>
                    <div class="flex flex-col sm:flex-row sm:gap-4 py-2.5"><dt class="text-slate-500 sm:w-48 shrink-0 font-medium">Tahun</dt><dd class="text-ink">{{ $pengajuan->tahun_implementasi }}</dd></div>
                </dl>
            </div>

            {{-- Bagian Tim --}}
            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-7 shadow-sm">
                <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-100">
                    <h2 class="font-bold text-ink text-base">Ketua &amp; Anggota Tim</h2>
                    <a href="{{ route('peserta.pengajuan.step3', $pengajuan->uuid) }}" class="text-xs font-bold text-brand-blue hover:underline">Edit</a>
                </div>
                <ul class="text-sm space-y-2">
                    @foreach ($anggotaKelompok as $anggota)
                        <li class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-200/60">
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
            </div>

            {{-- Bagian Dokumen --}}
            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-7 shadow-sm">
                <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-100">
                    <h2 class="font-bold text-ink text-base">Dokumen Kelengkapan</h2>
                    <a href="{{ route('peserta.pengajuan.step4', $pengajuan->uuid) }}" class="text-xs font-bold text-brand-blue hover:underline">Edit</a>
                </div>
                @if (count($dokumenBelumLengkap) > 0)
                    <div class="rounded-2xl bg-rose-50/80 border border-rose-200 text-rose-800 text-xs sm:text-sm p-4">
                        <p class="font-bold mb-1.5 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            Dokumen berikut belum lengkap:
                        </p>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($dokumenBelumLengkap as $jenis)
                                <li>{{ $namaDokumen[$jenis] ?? $jenis }}</li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <ul class="text-xs sm:text-sm space-y-2.5">
                        @foreach ($dokumenTersimpan as $jenis => $dok)
                            <li class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-200/60">
                                <span class="font-semibold text-slate-700">{{ $namaDokumen[$jenis] ?? $jenis }}</span>
                                <a href="{{ $dok->tautan }}" target="_blank" rel="noopener noreferrer" class="text-brand-blue font-bold hover:underline inline-flex items-center gap-1">
                                    <span>Buka Tautan</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            {{-- Bagian Proposal --}}
            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-7 shadow-sm">
                <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-100">
                    <h2 class="font-bold text-ink text-base">Isian Komponen Proposal</h2>
                    <a href="{{ route('peserta.pengajuan.step4', $pengajuan->uuid) }}" class="text-xs font-bold text-brand-blue hover:underline">Edit</a>
                </div>
                @if (count($isianBelumLengkap) > 0)
                    <div class="rounded-2xl bg-rose-50/80 border border-rose-200 text-rose-800 text-xs sm:text-sm p-4">
                        <p class="font-bold mb-1.5 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            Komponen proposal berikut belum diisi:
                        </p>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($isianBelumLengkap as $namaKomponen)
                                <li>{{ $namaKomponen }}</li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <div class="flex items-center gap-2 p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm font-semibold">
                        <svg class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span>Semua komponen kriteria proposal dan tautan bukti dukung telah lengkap terisi.</span>
                    </div>
                @endif
            </div>
        </div>

        <div class="mt-8 flex justify-end">
            @if (count($dokumenBelumLengkap) > 0 || count($isianBelumLengkap) > 0)
                <a href="{{ route('peserta.pengajuan.step4', $pengajuan->uuid) }}"
                    class="inline-flex items-center gap-2 bg-slate-800 hover:bg-slate-900 text-white font-bold rounded-xl px-7 py-3.5 text-sm transition-colors shadow-sm">
                    <span>Lengkapi Data Terlebih Dahulu</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            @else
                <form method="POST" action="{{ route('peserta.pengajuan.step5.submit', $pengajuan->uuid) }}"
                    onsubmit="return confirm('Apakah Anda yakin seluruh isian sudah benar? Setelah dikirim, pengajuan akan masuk tahap verifikasi Panitia.');">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-600 to-emerald-500 hover:from-emerald-500 hover:to-emerald-600 text-white font-bold rounded-xl px-8 py-4 text-sm sm:text-base transition-all duration-200 shadow-lg shadow-emerald-600/20 active:scale-95">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        <span>Kirim Pengajuan Sekarang</span>
                    </button>
                </form>
            @endif
        </div>
    </div>
@endsection
