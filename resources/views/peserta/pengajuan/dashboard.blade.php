@extends('layouts.peserta')

@section('title', 'Dashboard Saya')

@section('content')
    <div class="flex items-start justify-between gap-4 flex-wrap mb-6">
        <div>
            <h1 class="text-2xl font-bold">Dashboard Saya</h1>
            <p class="text-slate-500 mt-1">Kelola dan pantau pengajuan inovasimu.</p>
        </div>
        @unless ($sudahLewatDeadline)
            <a href="{{ route('peserta.pengajuan.step1') }}"
                class="bg-brand-amber hover:bg-brand-amber-dark text-brand-navy font-semibold rounded-xl px-5 py-2.5 transition-colors">
                + Buat Pengajuan Baru
            </a>
        @endunless
    </div>

    @if ($errors->any())
        <div class="mb-5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm p-3">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('sukses'))
        <div class="mb-5 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm p-3">
            {{ session('sukses') }}
        </div>
    @endif

    @if ($sudahLewatDeadline)
        <div class="mb-5 bg-ink text-white rounded-xl px-5 py-3 text-sm">
            Sudah lewat deadline pengajuan, tidak bisa membuat pengajuan baru lagi.
        </div>
    @endif

    @if ($daftarPengajuan->isEmpty())
        <div class="bg-white border border-line rounded-2xl p-8 text-center text-slate-500">
            Belum ada pengajuan. Mulai pengajuan baru untuk mengikuti TERANG NONA 2026.
        </div>
    @else
        <div class="space-y-4">
            @foreach ($daftarPengajuan as $item)
                <div class="bg-white border border-line rounded-2xl p-5 {{ $item->status === 'perlu_perbaikan' ? 'border-l-4 border-l-red-400' : '' }}">
                    <div class="flex items-start justify-between gap-3 flex-wrap">
                        <h2 class="font-semibold">{{ $item->nama_inovasi }} ({{ $item->akronim }})</h2>
                        <x-badge-status :status="$item->status" />
                    </div>

                    @if ($item->status === 'draft')
                        <div class="mt-4 flex gap-2 flex-wrap">
                            <a href="{{ route('peserta.pengajuan.step1.edit', $item->uuid) }}"
                                class="bg-brand-navy hover:bg-brand-navy-soft text-white text-sm font-semibold rounded-xl px-5 py-2 transition-colors">
                                Lanjutkan Pengajuan
                            </a>
                            <form method="POST" action="{{ route('peserta.pengajuan.hapus', $item->uuid) }}"
                                onsubmit="return confirm('Yakin mau hapus pengajuan draft ini? Tidak bisa dikembalikan.');">
                                @csrf
                                <button type="submit" class="border border-red-300 text-red-700 hover:bg-red-50 text-sm font-semibold rounded-xl px-5 py-2 transition-colors">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    @endif

                    @if ($item->status === 'perlu_perbaikan')
                        <div class="mt-4 bg-red-50 border border-red-200 rounded-xl p-4 text-sm">
                            <strong class="font-semibold text-red-800">Alasan dari Panitia:</strong>
                            <p class="text-red-700 mt-1">{{ $catatanPengembalian[$item->id] ?? '(tidak ada catatan)' }}</p>
                            <a href="{{ route('peserta.pengajuan.step1.edit', $item->uuid) }}"
                                class="inline-block mt-3 bg-brand-amber hover:bg-brand-amber-dark text-brand-navy text-sm font-semibold rounded-xl px-5 py-2 transition-colors">
                                Perbaiki Pengajuan Ini
                            </a>
                        </div>
                    @endif

                    @if ($item->status === 'ditolak')
                        <div class="mt-4 bg-surface border border-line rounded-xl p-4 text-sm">
                            <strong class="font-semibold">Alasan Ditolak:</strong>
                            <p class="text-slate-600 mt-1">{{ $catatanPengembalian[$item->id] ?? '(tidak ada catatan)' }}</p>
                        </div>
                    @endif

                    @if ($item->status === 'menunggu_pemeriksaan')
                        <p class="mt-3 text-sm text-slate-500">Pengajuan sedang diperiksa Panitia.</p>
                    @endif

                    @if ($item->status === 'disetujui')
                        <p class="mt-3 text-sm text-slate-500">Pengajuan disetujui dan masuk tahap penilaian Juri.</p>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
@endsection