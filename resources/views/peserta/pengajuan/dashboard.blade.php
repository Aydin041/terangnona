@extends('layouts.peserta')

@section('title', 'Dashboard Saya')

@section('content')
    <div class="flex items-start justify-between gap-4 flex-wrap mb-8">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-ink tracking-tight">Dashboard Saya</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola dan pantau seluruh status pengajuan inovasimu.</p>
        </div>
        @unless ($sudahLewatDeadline)
            <a href="{{ route('peserta.pengajuan.step1') }}"
                class="inline-flex items-center gap-2 bg-gradient-to-r from-brand-amber to-amber-500 hover:from-amber-400 hover:to-amber-500 text-brand-navy font-bold rounded-xl px-5 py-2.5 text-sm transition-all duration-200 shadow-md shadow-amber-500/15 active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                <span>Buat Pengajuan Baru</span>
            </a>
        @endunless
    </div>

    @php
        $pesertaLogin = Auth::guard('peserta')->user();
        $tampilSurvei = \App\Models\Pengaturan::statusSurvei() === 'dibuka'
            && $pesertaLogin->layakSurvei()
            && ! \App\Models\SurveiPartisipasi::where('peserta_id', $pesertaLogin->id)->exists();
    @endphp

    @if ($tampilSurvei)
        <div class="mb-6 bg-white border border-slate-200/80 border-l-4 border-l-brand-amber rounded-2xl p-5 shadow-sm flex items-center justify-between gap-4 flex-wrap">
            <div>
                <h2 class="font-bold text-ink text-base">Survei Kepuasan sedang dibuka</h2>
                <p class="text-sm text-slate-500 mt-0.5">
                    Bantu kami meningkatkan TERANG NONA. Ditutup pada
                    {{ \App\Models\Pengaturan::ambil()->survei_ditutup_pada->copy()->locale('id')->translatedFormat('j F Y, H.i') }} WIB.
                </p>
            </div>
            <a href="{{ route('peserta.survei.form') }}" class="rounded-xl border border-slate-200 bg-white hover:bg-slate-50 px-5 py-2.5 text-sm font-bold text-ink transition-colors shadow-2xs">
                Isi Survei
            </a>
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 rounded-2xl bg-red-50/80 border border-red-200 text-red-700 text-sm p-4">
            <ul class="list-disc list-inside space-y-1 font-medium">
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

    @if ($sudahLewatDeadline)
        <div class="mb-6 bg-slate-800 text-white rounded-2xl px-5 py-3.5 text-sm flex items-center gap-3 shadow-sm">
            <svg class="w-5 h-5 text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            <span>Batas waktu pengajuan telah berakhir. Anda tidak dapat membuat pengajuan baru lagi.</span>
        </div>
    @endif

    @if ($daftarPengajuan->isEmpty())
        <div class="bg-white border border-slate-200/80 rounded-3xl p-12 text-center shadow-sm">
            <div class="w-16 h-16 rounded-2xl bg-slate-50 border border-slate-200/60 flex items-center justify-center mx-auto mb-4 text-slate-400">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <h3 class="font-bold text-ink text-lg">Belum Ada Pengajuan</h3>
            <p class="text-sm text-slate-500 mt-1 max-w-sm mx-auto">Mulai pengajuan baru untuk berpartisipasi dalam kompetisi inovasi TERANG NONA {{ \App\Models\TahapJadwal::tahun() }}.</p>
            @unless ($sudahLewatDeadline)
                <div class="mt-6">
                    <a href="{{ route('peserta.pengajuan.step1') }}" class="inline-flex items-center gap-2 bg-brand-navy hover:bg-brand-navy-soft text-white text-sm font-semibold rounded-xl px-5 py-2.5 transition-colors">
                        + Buat Pengajuan Sekarang
                    </a>
                </div>
            @endunless
        </div>
    @else
        <div class="space-y-4">
            @foreach ($daftarPengajuan as $item)
                <div class="bg-white border rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-200
                    {{ $item->status === 'perlu_perbaikan' ? 'border-l-4 border-l-rose-500 border-slate-200/80' : 'border-slate-200/80' }}">
                    <div class="flex items-start justify-between gap-4 flex-wrap">
                        <div>
                            <h2 class="text-lg font-bold text-ink">{{ $item->nama_inovasi }} <span class="text-slate-500 font-medium">({{ $item->akronim }})</span></h2>
                            <p class="text-xs text-slate-400 mt-1">Dibuat pada {{ $item->created_at ? $item->created_at->format('d M Y, H:i') : '-' }} WIB</p>
                        </div>
                        <x-badge-status :status="$item->status" />
                    </div>

                    @if ($item->status === 'draft')
                        <div class="mt-5 pt-4 border-t border-slate-100 flex gap-2.5 flex-wrap items-center">
                            <a href="{{ route('peserta.pengajuan.step1.edit', $item->uuid) }}"
                                class="inline-flex items-center gap-1.5 bg-brand-navy hover:bg-brand-navy-soft text-white text-xs sm:text-sm font-semibold rounded-xl px-4 py-2 transition-colors shadow-2xs">
                                <span>Lanjutkan Pengisian</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                            <form method="POST" action="{{ route('peserta.pengajuan.hapus', $item->uuid) }}"
                                onsubmit="return confirm('Yakin mau hapus pengajuan draft ini? Tidak bisa dikembalikan.');">
                                @csrf
                                <button type="submit" class="border border-rose-200 text-rose-600 hover:bg-rose-50 text-xs sm:text-sm font-semibold rounded-xl px-4 py-2 transition-colors">
                                    Hapus Draft
                                </button>
                            </form>
                        </div>
                    @endif

                    @if ($item->status === 'perlu_perbaikan')
                        <div class="mt-4 bg-rose-50/70 border border-rose-200 rounded-xl p-4 text-sm">
                            <strong class="font-bold text-rose-800 block">Catatan Perbaikan dari Panitia:</strong>
                            <p class="text-rose-700 mt-1 leading-relaxed">{{ $catatanPengembalian[$item->id] ?? '(tidak ada catatan)' }}</p>
                            <a href="{{ route('peserta.pengajuan.step1.edit', $item->uuid) }}"
                                class="inline-flex items-center gap-1.5 mt-3 bg-brand-amber hover:bg-brand-amber-dark text-brand-navy text-xs sm:text-sm font-bold rounded-xl px-4 py-2 transition-colors shadow-sm">
                                <span>Perbaiki Dokumen Sekarang</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                        </div>
                    @endif

                    @if ($item->status === 'ditolak')
                        <div class="mt-4 bg-slate-50 border border-slate-200 rounded-xl p-4 text-sm">
                            <strong class="font-bold text-slate-800 block">Alasan Ditolak:</strong>
                            <p class="text-slate-600 mt-1 leading-relaxed">{{ $catatanPengembalian[$item->id] ?? '(tidak ada catatan)' }}</p>
                        </div>
                    @endif

                    @if ($item->status === 'menunggu_pemeriksaan')
                        <p class="mt-3 text-xs sm:text-sm text-slate-500 flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-sky-500 animate-pulse"></span>
                            Pengajuan sedang dalam antrean verifikasi dan pemeriksaan Panitia.
                        </p>
                    @endif

                    @if ($item->status === 'disetujui')
                        <p class="mt-3 text-xs sm:text-sm text-emerald-700 flex items-center gap-1.5 font-medium">
                            <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            Pengajuan telah disetujui panitia dan masuk ke tahap penilaian dewan juri.
                        </p>
                    @endif

                    @if ($item->status !== 'draft')
                        <div class="mt-4 pt-3 border-t border-slate-100">
                            <a href="{{ route('peserta.pengajuan.lihat', $item->uuid) }}"
                                class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-bold text-brand-blue hover:text-brand-blue-light transition-colors">
                                <span>Lihat Rincian Pengajuan</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
@endsection
