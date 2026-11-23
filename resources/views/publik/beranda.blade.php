@extends('layouts.publik')

@push('gaya')
    <style>
        /* Foto tokoh hero dengan blending yang lebih smooth */
        .hero { position: relative; overflow: hidden; }
        .hero-isi { position: relative; }
        .hero-foto {
            position: absolute; left: 32%; top: -0.5rem; height: 33rem; width: auto; max-width: none;
            opacity: .42; z-index: 0; pointer-events: none; user-select: none;
        }
        .hero-teks, .hero-logo { position: relative; z-index: 1; }
        .hero-teks { max-width: 38rem; }

        /* Grid kartu jadwal penting */
        .kartu-jadwal-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: .875rem; }
        @media (min-width: 640px) { .kartu-jadwal-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 1rem; } }
        @media (min-width: 1024px) { .kartu-jadwal-grid { grid-template-columns: repeat(6, minmax(0, 1fr)); } }
        @media (max-width: 1023px) { .hero-foto { display: none; } }
    </style>
@endpush

@section('content')
    {{-- ===== HERO SECTION ===== --}}
    <section class="hero bg-brand-navy bg-[radial-gradient(ellipse_at_70%_30%,#1a3672_0%,#0a1431_70%)] relative">
        <div class="absolute inset-0 bg-[linear-gradient(to_bottom,transparent,rgba(10,20,49,0.4))] pointer-events-none"></div>

        <div class="hero-isi max-w-6xl mx-auto px-4 sm:px-6 pt-12 sm:pt-16 pb-24 sm:pb-28 flex flex-col lg:flex-row items-center lg:justify-between gap-10 text-center lg:text-left">

            @if ($fotoHero)
                <img src="{{ asset($fotoHero) }}" alt="" aria-hidden="true" class="hero-foto" fetchpriority="high">
            @endif

            <div class="hero-teks order-2 lg:order-1 lg:flex-1">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/5 border border-white/10 text-xs font-medium tracking-wide text-slate-200 uppercase mb-4 shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-brand-amber animate-pulse"></span>
                    Dinas Tenaga Kerja dan Transmigrasi Provinsi Jawa Tengah
                </div>

                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white leading-tight tracking-tight">
                    Kompetisi Inovasi <br class="hidden sm:inline">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-300 via-brand-amber to-amber-500">TERANG NONA</span> {{ $tahunKompetisi }}
                </h1>

                {{-- Status Pendaftaran --}}
                <div class="mt-5">
                    <span class="inline-flex items-center gap-2 text-xs sm:text-sm font-semibold rounded-full px-4 py-1.5 backdrop-blur-sm border {{ $statusDaftar === 'berlangsung' ? 'border-brand-amber/50 bg-brand-amber/10 text-brand-amber' : 'border-white/20 bg-white/5 text-slate-300' }}">
                        @if ($statusDaftar === 'berlangsung')
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
                            Pendaftaran dibuka &middot; {{ $daftar['mulai_c']->copy()->locale('id')->translatedFormat('j F') }} &ndash; {{ $daftar['selesai_c']->copy()->locale('id')->translatedFormat('j F Y') }}
                        @elseif ($statusDaftar === 'belum')
                            Pendaftaran dibuka mulai {{ $daftar['mulai_c']->copy()->locale('id')->translatedFormat('j F Y') }}
                        @else
                            Pendaftaran ditutup &middot; {{ $daftar['selesai_c']->copy()->locale('id')->translatedFormat('j F Y') }}
                        @endif
                    </span>
                </div>

                {{-- Tombol Tindakan --}}
                <div class="mt-6 flex flex-wrap gap-3.5 justify-center lg:justify-start items-center">
                    @if ($statusDaftar === 'berlangsung')
                        <a href="{{ route('peserta.register') }}"
                            class="inline-flex items-center gap-2 bg-gradient-to-r from-brand-amber to-amber-500 hover:from-amber-400 hover:to-amber-500 text-brand-navy font-bold rounded-xl px-7 py-3.5 transition-all duration-200 shadow-lg shadow-amber-500/20 hover:shadow-amber-500/35 active:scale-95">
                            <span>Daftar sebagai Peserta</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    @else
                        <span aria-disabled="true" class="bg-white/10 border border-white/15 text-slate-400 font-semibold rounded-xl px-6 py-3 cursor-not-allowed">
                            {{ $statusDaftar === 'belum' ? 'Pendaftaran Belum Dibuka' : 'Pendaftaran Ditutup' }}
                        </span>
                    @endif

                    <a href="{{ route('tentang') }}"
                        class="inline-flex items-center text-sm font-semibold text-slate-200 hover:text-white bg-white/5 hover:bg-white/10 border border-white/10 hover:border-white/30 rounded-xl px-5 py-3 transition-all duration-200">
                        Pelajari Selengkapnya
                    </a>
                </div>

                {{-- Slogan --}}
                <div class="mt-8 pt-6 border-t border-white/10 flex items-center justify-center lg:justify-start gap-3">
                    <div class="w-1.5 h-8 rounded-full bg-brand-amber shrink-0"></div>
                    <p class="text-sm font-medium italic text-slate-300 text-left">
                        "Ngopeni lan Nglakoni Inovasi Ketenagakerjaan dan Ketransmigrasian Jawa Tengah"
                    </p>
                </div>
            </div>

            <div class="hero-logo order-1 lg:order-2 lg:flex-none">
                <div class="relative group">
                    <div class="absolute -inset-4 bg-brand-amber/20 rounded-full blur-2xl group-hover:bg-brand-amber/30 transition-colors"></div>
                    <img src="{{ asset('images/logo-terang-nona-emas.png') }}" alt="TERANG NONA {{ $tahunKompetisi }}" class="relative h-48 sm:h-56 lg:h-80 w-auto mx-auto drop-shadow-2xl transition-transform duration-300 group-hover:scale-102">
                </div>
            </div>
        </div>
    </section>

    {{-- ===== TANGGAL PENTING (KARTU STATS / JADWAL) ===== --}}
    <section class="max-w-6xl mx-auto px-4 sm:px-6 -mt-10 sm:-mt-12 relative z-10">
        <div class="kartu-jadwal-grid">
            @foreach ($sorotan as $s)
                <div class="bg-white border border-slate-200/80 rounded-2xl p-4 sm:p-5 shadow-sm hover:shadow-md transition-all duration-200 hover:-translate-y-0.5 group">
                    <p class="text-base sm:text-lg font-extrabold text-brand-blue group-hover:text-brand-blue-light transition-colors">{{ $s['teks_ringkas'] }}</p>
                    <p class="text-xs sm:text-sm text-slate-600 mt-1 font-medium leading-snug">{{ $s['sorot'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <div class="pb-20"></div>
@endsection
