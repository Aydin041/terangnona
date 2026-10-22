@extends('layouts.peserta')

@section('title', 'Pengajuan - Langkah 5')

@section('content')
    <div class="max-w-3xl mx-auto">
        <p class="mb-4"><a href="{{ route('peserta.pengajuan.step4', $pengajuan->id) }}" class="text-sm text-slate-500 hover:text-ink">← Kembali ke Langkah 4</a></p>

        @include('peserta.pengajuan._stepper', ['langkah' => 5])

        <h1 class="text-2xl font-bold mb-5">Review & Submit</h1>

        @if ($errors->any())
            <div class="mb-5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm p-3">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="space-y-4">
            <div class="bg-white border border-line rounded-2xl p-6">
                <h2 class="font-semibold mb-3">Profil Inovasi</h2>
                <dl class="text-sm divide-y divide-line">
                    <div class="flex flex-col sm:flex-row sm:gap-4 py-2"><dt class="text-slate-500 sm:w-48 shrink-0">Nama Inovasi</dt><dd>{{ $pengajuan->nama_inovasi }} ({{ $pengajuan->akronim }})</dd></div>
                    <div class="flex flex-col sm:flex-row sm:gap-4 py-2"><dt class="text-slate-500 sm:w-48 shrink-0">Kategori</dt><dd>{{ $pengajuan->kategori->nama }}</dd></div>
                    <div class="flex flex-col sm:flex-row sm:gap-4 py-2"><dt class="text-slate-500 sm:w-48 shrink-0">Bentuk Inovasi</dt><dd>{{ $pengajuan->bentuk_inovasi }}</dd></div>
                    <div class="flex flex-col sm:flex-row sm:gap-4 py-2"><dt class="text-slate-500 sm:w-48 shrink-0">Tahun Implementasi</dt><dd>{{ $pengajuan->tahun_implementasi }}</dd></div>
                </dl>
            </div>

            <div class="bg-white border border-line rounded-2xl p-6">
                <h2 class="font-semibold mb-3">Ketua & Anggota</h2>
                <ul class="text-sm space-y-1">
                    @foreach ($anggotaKelompok as $anggota)
                        <li>{{ $anggota->nama }} ({{ $anggota->kontak }}) @if ($anggota->adalah_ketua) <span class="text-brand-amber-dark font-semibold">— Ketua</span> @endif</li>
                    @endforeach
                </ul>
            </div>

            <div class="bg-white border border-line rounded-2xl p-6">
                <h2 class="font-semibold mb-3">Dokumen</h2>
                @if (count($dokumenBelumLengkap) > 0)
                    <div class="rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm p-4">
                        <p class="font-semibold mb-1">Dokumen berikut belum lengkap:</p>
                        <ul class="list-disc list-inside">
                            @foreach ($dokumenBelumLengkap as $jenis)
                                <li>{{ $jenis }}</li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <ul class="text-sm space-y-1.5">
                        @foreach ($dokumenTersimpan as $jenis => $dok)
                            <li>
                                <strong class="font-semibold">{{ $jenis }}:</strong>
                                <a href="{{ $dok->tautan }}" target="_blank" rel="noopener noreferrer" class="text-brand-blue underline break-all">{{ $dok->label }}</a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <div class="bg-white border border-line rounded-2xl p-6">
                <h2 class="font-semibold mb-3">Isian Proposal</h2>
                @if (count($isianBelumLengkap) > 0)
                    <div class="rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm p-4">
                        <p class="font-semibold mb-1">Komponen berikut belum diisi:</p>
                        <ul class="list-disc list-inside">
                            @foreach ($isianBelumLengkap as $namaKomponen)
                                <li>{{ $namaKomponen }}</li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <p class="text-sm text-green-700">Semua komponen sudah diisi.</p>
                @endif
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            @if (count($dokumenBelumLengkap) > 0 || count($isianBelumLengkap) > 0)
                <a href="{{ route('peserta.pengajuan.step4', $pengajuan->id) }}"
                    class="bg-brand-navy hover:bg-brand-navy-soft text-white font-semibold rounded-xl px-8 py-3 transition-colors">
                    ← Kembali ke Langkah 4 untuk Melengkapi
                </a>
            @else
                <form method="POST" action="{{ route('peserta.pengajuan.step5.submit', $pengajuan->id) }}">
                    @csrf
                    <button type="submit" class="bg-brand-amber hover:bg-brand-amber-dark text-brand-navy font-semibold rounded-xl px-8 py-3 transition-colors">
                        Submit Pengajuan
                    </button>
                </form>
            @endif
        </div>
    </div>
@endsection