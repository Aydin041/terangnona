@extends('layouts.publik')

@section('judul', 'Download - TERANG NONA ' . $tahunKompetisi)

@push('gaya')
    <style>
        .ikon-berkas {
            flex: none; width: 48px; height: 56px; border-radius: .6rem; color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: .7rem; font-weight: 800; letter-spacing: .02em;
        }
        .ikon-pdf { background: #d9484a; }
        .ikon-docx { background: #2b6cb0; }
        .chip-filter {
            border: 1px solid #e1e6f0; background: #fff; border-radius: .75rem;
            padding: .4rem 1rem; font-size: .875rem; font-weight: 600; cursor: pointer;
        }
        .chip-filter.aktif { background: #0a1431; border-color: #0a1431; color: #fff; }
    </style>
@endpush

@section('content')
    <section class="mx-auto px-4 sm:px-6 pt-12 pb-24" style="max-width:56rem">
        <p class="text-xs font-bold tracking-widest text-brand-amber-dark uppercase">Dokumen</p>
        <h1 class="text-3xl font-bold mt-1 mb-2">Download</h1>
        <p class="text-slate-500">Dokumen penting TERANG NONA {{ $tahunKompetisi }}. Terbuka untuk semua, tanpa perlu login.</p>

        <div class="flex gap-2 mt-5 mb-8" id="filter-berkas">
            <button type="button" class="chip-filter aktif" data-filter="semua">Semua</button>
            <button type="button" class="chip-filter" data-filter="pdf">PDF</button>
            <button type="button" class="chip-filter" data-filter="docx">Word</button>
        </div>

        @foreach ($kelompok as $namaKelompok => $daftarBerkas)
            <div class="kelompok-berkas mb-8">
                <h2 class="text-lg font-bold mb-3">{{ $namaKelompok }}</h2>
                <div class="space-y-3">
                    @foreach ($daftarBerkas as $item)
                        <div class="item-berkas bg-white border border-line rounded-2xl p-4 flex items-center gap-4" data-jenis="{{ $item['jenis'] }}">
                            <div class="ikon-berkas {{ $item['jenis'] === 'pdf' ? 'ikon-pdf' : 'ikon-docx' }}">{{ $item['label_jenis'] }}</div>
                            <div class="min-w-0 flex-1">
                                <p class="font-semibold leading-snug">{{ $item['judul'] }}</p>
                                <p class="text-sm text-slate-500 mt-0.5">
                                    {{ $item['deskripsi'] }} &middot; {{ $item['label_jenis'] }}@if ($item['ukuran']) &middot; {{ $item['ukuran'] }}@endif
                                </p>
                            </div>
                            @if ($item['ada'])
                                <a href="{{ $item['url'] }}" download="{{ $item['nama_unduhan'] }}"
                                    class="shrink-0 bg-brand-amber hover:bg-brand-amber-dark text-brand-navy font-semibold rounded-xl px-6 py-2.5 transition-colors">
                                    Unduh
                                </a>
                            @else
                                <span aria-disabled="true" class="shrink-0 bg-slate-100 text-slate-400 font-semibold rounded-xl px-5 py-2.5 cursor-not-allowed">
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

                    // Sembunyikan judul kelompok yang tidak punya berkas tampil.
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