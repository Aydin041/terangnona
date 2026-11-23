@extends('layouts.peserta')

@section('title', 'Pengajuan - Langkah 3')

@section('content')
    @php
        $kelasInput = 'w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-ink placeholder-slate-400 bg-white transition-all focus:outline-none focus:ring-2 focus:ring-brand-amber/30 focus:border-brand-amber shadow-2xs';
    @endphp

    <div class="max-w-3xl mx-auto">
        <a href="{{ route('peserta.pengajuan.step2', $pengajuan->uuid) }}" class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-semibold text-slate-500 hover:text-brand-navy transition-colors mb-6 group">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Langkah 2
        </a>

        @include('peserta.pengajuan._stepper', ['langkah' => 3])

        <div class="mb-6">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-ink tracking-tight">Data Ketua &amp; Anggota Tim</h1>
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

        <form method="POST" action="{{ route('peserta.pengajuan.step3.submit', $pengajuan->uuid) }}" class="space-y-6">
            @csrf

            {{-- Data Ketua Tim --}}
            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-7 shadow-sm">
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-2.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-brand-amber"></span>
                        <h2 class="font-bold text-ink text-base">Ketua Tim Inovator</h2>
                    </div>
                    <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-800 border border-amber-200">Akun Anda</span>
                </div>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs sm:text-sm font-bold text-ink mb-1.5">Nama Ketua</label>
                        <input type="text" value="{{ $peserta->nama }}" disabled class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-600 font-medium cursor-not-allowed">
                    </div>
                    <div>
                        <label class="block text-xs sm:text-sm font-bold text-ink mb-1.5">Kontak / No. WhatsApp</label>
                        <input type="text" value="{{ $peserta->kontak }}" disabled class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-600 font-medium cursor-not-allowed">
                    </div>
                </div>
            </div>

            {{-- Data Anggota Tim Tambahan --}}
            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-7 shadow-sm">
                <div class="mb-4 pb-3 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h2 class="font-bold text-ink text-base">Anggota Tim Tambahan</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Opsional jika inovasi digagas secara kelompok/kolaborasi.</p>
                    </div>
                </div>

                <div id="anggota-container" class="space-y-3">
                    @foreach ($anggotaLain as $anggota)
                        <div class="baris-anggota border border-slate-200/80 rounded-2xl p-4 grid sm:grid-cols-2 gap-3 items-end bg-slate-50/50">
                            <div>
                                <label class="block text-xs font-bold text-ink mb-1">Nama Anggota</label>
                                <input type="text" name="anggota_nama[]" value="{{ $anggota->nama }}" placeholder="Nama anggota" class="{{ $kelasInput }}">
                            </div>
                            <div class="flex gap-2 items-end">
                                <div class="flex-1 min-w-0">
                                    <label class="block text-xs font-bold text-ink mb-1">Kontak Anggota</label>
                                    <input type="text" name="anggota_kontak[]" value="{{ $anggota->kontak }}" placeholder="No. HP/WA" class="{{ $kelasInput }}">
                                </div>
                                <button type="button" onclick="hapusAnggota(this)" class="text-rose-600 hover:text-rose-800 hover:bg-rose-50 text-xs sm:text-sm font-semibold border border-rose-200 rounded-xl px-3.5 h-[46px] transition-colors shrink-0">
                                    Hapus
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <button type="button" onclick="tambahAnggota()" class="mt-4 inline-flex items-center gap-1.5 text-xs sm:text-sm font-bold text-brand-navy border border-slate-200 hover:border-brand-amber hover:bg-amber-50/50 rounded-xl px-4 py-2.5 transition-colors shadow-2xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    <span>Tambah Anggota</span>
                </button>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="inline-flex items-center gap-2 bg-gradient-to-r from-brand-amber to-amber-500 hover:from-amber-400 hover:to-amber-500 text-brand-navy font-bold rounded-xl px-7 py-3.5 text-sm transition-all duration-200 shadow-md shadow-amber-500/15 active:scale-95">
                    <span>Lanjut ke Langkah 4</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </div>
        </form>
    </div>

    <script>
        function tambahAnggota() {
            const container = document.getElementById('anggota-container');
            const div = document.createElement('div');
            div.className = 'baris-anggota border border-slate-200/80 rounded-2xl p-4 grid sm:grid-cols-2 gap-3 items-end bg-slate-50/50 animate-fadeIn';
            div.innerHTML = `
                <div>
                    <label class="block text-xs font-bold text-ink mb-1">Nama Anggota</label>
                    <input type="text" name="anggota_nama[]" placeholder="Nama anggota" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-ink placeholder-slate-400 bg-white transition-all focus:outline-none focus:ring-2 focus:ring-brand-amber/30 focus:border-brand-amber shadow-2xs">
                </div>
                <div class="flex gap-2 items-end">
                    <div class="flex-1 min-w-0">
                        <label class="block text-xs font-bold text-ink mb-1">Kontak Anggota</label>
                        <input type="text" name="anggota_kontak[]" placeholder="No. HP/WA" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-ink placeholder-slate-400 bg-white transition-all focus:outline-none focus:ring-2 focus:ring-brand-amber/30 focus:border-brand-amber shadow-2xs">
                    </div>
                    <button type="button" onclick="hapusAnggota(this)" class="text-rose-600 hover:text-rose-800 hover:bg-rose-50 text-xs sm:text-sm font-semibold border border-rose-200 rounded-xl px-3.5 h-[46px] transition-colors shrink-0">Hapus</button>
                </div>
            `;
            container.appendChild(div);
        }

        function hapusAnggota(tombol) {
            tombol.closest('.baris-anggota').remove();
        }
    </script>
@endsection
