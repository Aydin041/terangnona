@extends('layouts.publik')

@push('gaya')
    <style>
        /* Foto tokoh di belakang judul pada bagian atas (hero).
           Berkas: public/images/hero-latar.webp (boleh juga .png, .jpg, atau .jpeg), sebaiknya PNG/WebP
           bertransparan (tokoh tanpa latar). Kalau berkasnya belum ada, hero tampil polos.
           Yang bisa diatur: opacity (kecerahan foto), left (geser kiri/kanan), top (naik/turun), height (ukuran). */
        .hero { position: relative; overflow: hidden; }
        .hero-isi { position: relative; }
        .hero-foto {
            position: absolute; left: 32%; top: -0.5rem; height: 33rem; width: auto; max-width: none;
            opacity: .42; z-index: 0; pointer-events: none; user-select: none;
        }
        .hero-teks, .hero-logo { position: relative; z-index: 1; }
        .hero-teks { max-width: 36rem; }

        /* Kartu tanggal penting di tepi bawah hero: 2 kolom di HP, 3 di tablet, 6 di layar lebar. */
        .kartu-jadwal-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: .75rem; }
        .kartu-tanggal { font-size: 1.0625rem; line-height: 1.3; }
        .kartu-jadwal-grid > div { padding: .9rem 1rem; }
        @media (min-width: 640px) { .kartu-jadwal-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 1rem; } }
        @media (min-width: 1024px) { .kartu-jadwal-grid { grid-template-columns: repeat(6, minmax(0, 1fr)); } }
        @media (max-width: 1023px) { .hero-foto { display: none; } }
    </style>
@endpush

@section('content')
    {{-- ===== HERO ===== --}}    <section class="hero bg-brand-navy bg-[radial-gradient(circle_at_75%_40%,#12295a_0%,#0a1431_65%)]">
        <div class="hero-isi max-w-6xl mx-auto px-4 sm:px-6 pt-12 pb-24 flex flex-col lg:flex-row items-center lg:justify-between gap-10 text-center lg:text-left">

            @if ($fotoHero)
                <img src="{{ asset($fotoHero) }}" alt="" aria-hidden="true" class="hero-foto" fetchpriority="high">
            @endif

            <div class="hero-teks order-2 lg:order-1 lg:flex-1">
                <p class="text-xs tracking-widest text-slate-300 uppercase">Dinas Tenaga Kerja dan Transmigrasi Provinsi Jawa Tengah</p>
                <h1 class="mt-3 text-4xl sm:text-5xl font-extrabold text-white leading-tight">
                    Kompetisi Inovasi <span class="text-brand-amber">TERANG NONA</span> {{ $tahunKompetisi }}
                </h1>

                <div class="mt-6">
                    <span class="inline-block text-xs sm:text-sm font-semibold rounded-full border px-4 py-1.5 {{ $statusDaftar === 'berlangsung' ? 'border-brand-amber text-brand-amber' : 'border-slate-500 text-slate-300' }}">
                        @if ($statusDaftar === 'berlangsung')
                            Pendaftaran dibuka &middot; {{ $daftar['mulai_c']->copy()->locale('id')->translatedFormat('j F') }} &ndash; {{ $daftar['selesai_c']->copy()->locale('id')->translatedFormat('j F Y') }}
                        @elseif ($statusDaftar === 'belum')
                            Pendaftaran dibuka mulai {{ $daftar['mulai_c']->copy()->locale('id')->translatedFormat('j F Y') }}
                        @else
                            Pendaftaran ditutup &middot; {{ $daftar['selesai_c']->copy()->locale('id')->translatedFormat('j F Y') }}
                        @endif
                    </span>
                </div>

                <div class="mt-6 flex flex-wrap gap-3 justify-center lg:justify-start">
                    @if ($statusDaftar === 'berlangsung')
                        <a href="{{ route('peserta.register') }}"
                            class="bg-brand-amber hover:bg-brand-amber-dark text-brand-navy font-semibold rounded-xl px-6 py-3 transition-colors">
                            Daftar sebagai Peserta
                        </a>
                    @else
                        <span aria-disabled="true" class="bg-slate-700 text-slate-400 font-semibold rounded-xl px-6 py-3 cursor-not-allowed">
                            {{ $statusDaftar === 'belum' ? 'Pendaftaran Belum Dibuka' : 'Pendaftaran Ditutup' }}
                        </span>
                    @endif
                </div>

                <p class="mt-8 text-sm italic text-slate-300 border-l-4 border-brand-amber pl-4 max-w-md mx-auto lg:mx-0 text-left">
                    Ngopeni lan Nglakoni Inovasi Ketenagakerjaan dan Ketransmigrasian Jawa Tengah
                </p>
            </div>

            <div class="hero-logo order-1 lg:order-2 lg:flex-none">
                <img src="{{ asset('images/logo-terang-nona-emas.png') }}" alt="TERANG NONA {{ $tahunKompetisi }}" class="h-52 lg:h-80 w-auto mx-auto">
            </div>
        </div>
    </section>

    {{-- ===== TANGGAL PENTING (kartu di tepi hero) ===== --}}    <section class="max-w-6xl mx-auto px-4 sm:px-6 -mt-12 relative z-10">
        <div class="kartu-jadwal-grid">
            @foreach ($sorotan as $s)
                <div class="bg-white border border-line rounded-2xl p-4 sm:p-5 shadow-sm">
                    <p class="kartu-tanggal font-bold text-brand-blue">{{ $s['teks_ringkas'] }}</p>
                    <p class="text-sm text-slate-500 mt-0.5">{{ $s['sorot'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <div class="pb-24"></div>
@endsection