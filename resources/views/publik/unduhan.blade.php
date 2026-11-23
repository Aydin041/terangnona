@extends('layouts.publik')

@section('judul', 'Download - TERANG NONA ' . $tahunKompetisi)

@push('gaya')
    <style>
        .ikon-berkas {
            flex: none; width: 46px; height: 52px; border-radius: .75rem; color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: .75rem; font-weight: 800; letter-spacing: .03em;
            box-shadow: 0 2px 4px rgba(0,0,0,0.06);
        }
        .ikon-pdf { background: linear-gradient(135deg, #e53e3e, #c53030); }
        .ikon-docx { background: linear-gradient(135deg, #3182ce, #2b6cb0); }
        .chip-filter {
            border: 1px solid #e1e6f0; background: #fff; border-radius: .75rem;
            padding: .45rem 1.15rem; font-size: .875rem; font-weight: 600; cursor: pointer;
            transition: all .2s ease;
        }
        .chip-filter:hover { border-color: #cbd5e1; background: #f8fafc; }
        .chip-filter.aktif { background: #0a1431; border-color: #0a1431; color: #fff; box-shadow: 0 2px 4px rgba(10,20,49,0.15); }
    </style>
@endpush

@section('content')
    <section class="max-w-4xl mx-auto px-4 sm:px-6 pt-10 pb-24">
        <a href="{{ route('landing') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-500 hover:text-brand-navy transition-colors mb-6 group">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Beranda
        </a>

        <div class="mb-6">
            <span class="inline-block text-xs font-bold tracking-wider text-brand-amber-dark bg-amber-50 border border-amber-200/60 rounded-full px-3 py-1 uppercase">Pusat Unduhan</span>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-ink mt-2 mb-2">Download Dokumen</h1>
            <p class="text-slate-600 text-sm sm:text-base">Dokumen panduan, format template, dan pengumuman resmi TERANG NONA {{ $tahunKompetisi }}.</p>
        </div>

        {{-- Filter Tab --}}
        <div class="flex gap-2.5 mb-8" id="filter-berkas">
            <button type="button" class="chip-filter aktif" data-filter="semua">Semua Berkas</button>
            <button type="button" class="chip-filter" data-filter="pdf">PDF</button>
            <button type="button" class="chip-filter" data-filter="docx">Word (DOCX)</button>
        </div>

        @foreach ($kelompok as $namaKelompok => $daftarBerkas)
            <div class="kelompok-berkas mb-10">
                <h2 class="text-lg font-bold text-ink mb-3.5 flex items-center gap-2">
                    <span class="w-2 h-4 rounded-full bg-brand-amber"></span>
                    {{ $namaKelompok }}
                </h2>
                <div class="space-y-3">
                    @foreach ($daftarBerkas as $item)
                        <div class="item-berkas bg-white border border-slate-200/80 rounded-2xl p-4 sm:p-5 flex items-center gap-4 shadow-sm hover:shadow-md transition-all duration-200" data-jenis="{{ $item['jenis'] }}">
                            <div class="ikon-berkas {{ $item['jenis'] === 'pdf' ? 'ikon-pdf' : 'ikon-docx' }}">{{ $item['label_jenis'] }}</div>
                            <div class="min-w-0 flex-1">
                                <p class="font-bold text-ink text-sm sm:text-base leading-snug">{{ $item['judul'] }}</p>
                                <p class="text-xs sm:text-sm text-slate-500 mt-1 font-medium">
                                    {{ $item['deskripsi'] }} &middot; <span class="uppercase font-semibold text-slate-600">{{ $item['label_jenis'] }}</span>@if ($item['ukuran']) &middot; {{ $item['ukuran'] }}@endif
                                </p>
                            </div>
                            @if ($item['ada'])
                                <a href="{{ $item['url'] }}" download="{{ $item['nama_unduhan'] }}"
                                    class="shrink-0 bg-brand-navy hover:bg-brand-navy-soft text-white font-semibold rounded-xl px-5 py-2.5 text-sm transition-all duration-200 shadow-sm active:scale-95 inline-flex items-center gap-2">
                                    <span>Unduh</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                </a>
                            @else
                                <span aria-disabled="true" class="shrink-0 bg-slate-100 text-slate-400 font-semibold rounded-xl px-4 py-2.5 text-xs sm:text-sm cursor-not-allowed">
                                    Belum tersedia
                                </span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </section>
@endsection

@push('skrip')
    <script>
        (function () {
            const tombol = document.querySelectorAll('#filter-berkas .chip-filter');

            tombol.forEach(function (satu) {
                satu.addEventListener('click', function () {
                    const jenis = satu.dataset.filter;

                    tombol.forEach(function (lain) { lain.classList.toggle('aktif', lain === satu); });

                    document.querySelectorAll('.item-berkas').forEach(function (item) {
                        item.style.display = (jenis === 'semua' || item.dataset.jenis === jenis) ? '' : 'none';
                    });

                    // Sembunyikan judul kelompok yang tidak punya berkas tampil
                    document.querySelectorAll('.kelompok-berkas').forEach(function (kelompok) {
                        const adaTampil = Array.from(kelompok.querySelectorAll('.item-berkas'))
                            .some(function (item) { return item.style.display !== 'none'; });
                        kelompok.style.display = adaTampil ? '' : 'none';
                    });
                });
            });
        })();
    </script>
@endpush
