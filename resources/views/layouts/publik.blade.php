<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('judul', 'TERANG NONA ' . $tahunKompetisi . ' - Kompetisi Inovasi Disnakertrans Provinsi Jawa Tengah')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('gaya')
</head>
<body class="bg-surface font-sans text-ink antialiased selection:bg-brand-amber selection:text-brand-navy min-h-screen flex flex-col">

    @php
        $aktif = fn ($rute) => request()->routeIs($rute)
            ? 'text-brand-amber border-brand-amber font-semibold'
            : 'text-slate-200 border-transparent hover:text-white hover:border-white/30';
        $aktifMobile = fn ($rute) => request()->routeIs($rute)
            ? 'bg-white/10 text-brand-amber font-semibold'
            : 'text-slate-200 hover:bg-white/5 hover:text-white';
    @endphp

    <header class="bg-brand-navy/95 backdrop-blur-md sticky top-0 z-40 border-b border-white/10 transition-shadow">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-3 flex items-center justify-between gap-4">
            {{-- Brand / Logo --}}
            <div class="flex items-center gap-8">
                <a href="{{ route('landing') }}" class="flex items-center gap-3 group">
                    <img src="{{ asset('images/logo-terang-nona-emas.png') }}" alt="TERANG NONA" class="h-9 w-auto transition-transform duration-200 group-hover:scale-105">
                    <span class="text-white font-bold tracking-tight text-lg">TERANG NONA</span>
                </a>

                {{-- Desktop Navigation --}}
                <nav class="hidden md:flex items-center gap-6 text-sm">
                    <a href="{{ route('tentang') }}" class="py-1.5 border-b-2 transition-all duration-200 {{ $aktif('tentang') }}">Tentang</a>
                    <a href="{{ route('jadwal') }}" class="py-1.5 border-b-2 transition-all duration-200 {{ $aktif('jadwal') }}">Jadwal</a>
                    <a href="{{ route('unduhan') }}" class="py-1.5 border-b-2 transition-all duration-200 {{ $aktif('unduhan') }}">Download</a>
                </nav>
            </div>

            {{-- Actions: Login Button + Mobile Hamburger Toggle --}}
            <div class="flex items-center gap-3">
                {{-- Dropdown Login --}}
                <div class="relative">
                    <button type="button" id="tombol-login"
                        class="inline-flex items-center gap-2 text-sm font-semibold text-white bg-white/5 hover:bg-white/10 border border-white/20 hover:border-white/40 rounded-xl px-4 py-2 transition-all duration-200 shadow-sm active:scale-95">
                        <span>Login</span>
                        <svg class="w-4 h-4 text-slate-300 transition-transform duration-200" id="panah-login" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="menu-login" class="hidden absolute right-0 mt-2 w-52 bg-white rounded-2xl shadow-xl border border-line py-1.5 z-50 transform origin-top-right transition-all">
                        <div class="px-4 py-2 text-xs font-bold uppercase tracking-wider text-slate-400">Pilih Portal</div>
                        <a href="{{ route('peserta.login') }}" class="flex items-center justify-between px-4 py-2.5 text-sm font-semibold text-ink hover:bg-surface hover:text-brand-blue transition-colors">
                            <span>Peserta Inovasi</span>
                            <span class="text-xs bg-amber-100 text-amber-800 rounded-md px-1.5 py-0.5">Peserta</span>
                        </a>
                        <div class="my-1.5 border-t border-line"></div>
                        <a href="{{ route('panitia.login') }}" class="block px-4 py-2 text-sm text-slate-600 hover:bg-surface hover:text-ink transition-colors">Panitia</a>
                        <a href="{{ route('juri.login') }}" class="block px-4 py-2 text-sm text-slate-600 hover:bg-surface hover:text-ink transition-colors">Dewan Juri</a>
                        <a href="{{ route('pimpinan.login') }}" class="block px-4 py-2 text-sm text-slate-600 hover:bg-surface hover:text-ink transition-colors">Pimpinan</a>
                    </div>
                </div>

                {{-- Hamburger Button (Mobile Only - Opsi A) --}}
                <button type="button" id="tombol-menu-mobile"
                    class="md:hidden inline-flex items-center justify-center p-2 rounded-xl text-slate-300 hover:text-white hover:bg-white/10 transition-colors focus:outline-none"
                    title="Menu Navigasi">
                    <svg id="ikon-burger" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg id="ikon-tutup" class="hidden w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile Navigation Menu (Collapsible - Opsi A) --}}
        <div id="menu-mobile" class="hidden md:hidden border-t border-white/10 bg-brand-navy px-4 pt-2 pb-4 space-y-1">
            <a href="{{ route('landing') }}" class="block px-3 py-2.5 rounded-xl text-base transition-colors {{ request()->routeIs('landing') ? 'bg-white/10 text-brand-amber font-semibold' : 'text-slate-200 hover:bg-white/5 hover:text-white' }}">Beranda</a>
            <a href="{{ route('tentang') }}" class="block px-3 py-2.5 rounded-xl text-base transition-colors {{ $aktifMobile('tentang') }}">Tentang</a>
            <a href="{{ route('jadwal') }}" class="block px-3 py-2.5 rounded-xl text-base transition-colors {{ $aktifMobile('jadwal') }}">Jadwal</a>
            <a href="{{ route('unduhan') }}" class="block px-3 py-2.5 rounded-xl text-base transition-colors {{ $aktifMobile('unduhan') }}">Download</a>
        </div>
    </header>

    <main class="flex-1">
        @yield('content')
    </main>

    @include('layouts._footer', ['padding' => 'py-6'])

    <script>
        (function () {
            // Dropdown Login
            const tombolLogin = document.getElementById('tombol-login');
            const menuLogin = document.getElementById('menu-login');
            const panahLogin = document.getElementById('panah-login');

            if (tombolLogin && menuLogin) {
                tombolLogin.addEventListener('click', function (e) {
                    e.stopPropagation();
                    const isHidden = menuLogin.classList.toggle('hidden');
                    if (panahLogin) panahLogin.classList.toggle('rotate-180', !isHidden);
                });

                document.addEventListener('click', function (e) {
                    if (!menuLogin.contains(e.target) && !tombolLogin.contains(e.target)) {
                        menuLogin.classList.add('hidden');
                        if (panahLogin) panahLogin.classList.remove('rotate-180');
                    }
                });

                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape') {
                        menuLogin.classList.add('hidden');
                        if (panahLogin) panahLogin.classList.remove('rotate-180');
                    }
                });
            }

            // Mobile Hamburger Menu (Opsi A)
            const tombolBurger = document.getElementById('tombol-menu-mobile');
            const menuMobile = document.getElementById('menu-mobile');
            const ikonBurger = document.getElementById('ikon-burger');
            const ikonTutup = document.getElementById('ikon-tutup');

            if (tombolBurger && menuMobile) {
                tombolBurger.addEventListener('click', function (e) {
                    e.stopPropagation();
                    const isHidden = menuMobile.classList.toggle('hidden');
                    ikonBurger.classList.toggle('hidden', !isHidden);
                    ikonTutup.classList.toggle('hidden', isHidden);
                });

                document.addEventListener('click', function (e) {
                    if (!menuMobile.contains(e.target) && !tombolBurger.contains(e.target)) {
                        menuMobile.classList.add('hidden');
                        ikonBurger.classList.remove('hidden');
                        ikonTutup.classList.add('hidden');
                    }
                });
            }
        })();
    </script>
    @stack('skrip')
</body>
</html>
