<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('judul', 'TERANG NONA ' . $tahunKompetisi . ' - Kompetisi Inovasi Disnakertrans Provinsi Jawa Tengah')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('gaya')
</head>
<body class="bg-surface font-sans text-ink antialiased">

    @php
        $aktif = fn ($rute) => request()->routeIs($rute)
            ? 'text-brand-amber border-brand-amber font-semibold'
            : 'text-slate-300 border-transparent hover:text-white';
    @endphp

    <header class="bg-brand-navy sticky top-0 z-30 border-b border-white/10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-3 flex items-center justify-between gap-4">
            <div class="flex items-center gap-8">
                <a href="{{ route('landing') }}" class="flex items-center gap-3">
                    <img src="{{ asset('images/logo-terang-nona-emas.png') }}" alt="TERANG NONA" class="h-9 w-auto">
                    <span class="text-white font-bold tracking-tight">TERANG NONA</span>
                </a>
                <nav class="flex items-center gap-6 text-sm">
                    <a href="{{ route('tentang') }}" class="py-1 border-b-2 transition-colors {{ $aktif('tentang') }}">Tentang</a>
                    <a href="{{ route('jadwal') }}" class="py-1 border-b-2 transition-colors {{ $aktif('jadwal') }}">Jadwal</a>
                    <a href="{{ route('unduhan') }}" class="py-1 border-b-2 transition-colors {{ $aktif('unduhan') }}">Download</a>
                </nav>
            </div>

            <div class="relative">
                <button type="button" id="tombol-login"
                    class="flex items-center gap-1.5 text-sm font-semibold text-white border border-slate-500 hover:border-white rounded-xl px-4 py-2 transition-colors">
                    Login
                    <span aria-hidden="true" class="text-xs">▾</span>
                </button>
                <div id="menu-login" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-line py-1 z-40">
                    <a href="{{ route('peserta.login') }}" class="block px-4 py-2.5 text-sm font-semibold text-ink hover:bg-surface">Peserta</a>
                    <div class="my-1 border-t border-line"></div>
                    <a href="{{ route('panitia.login') }}" class="block px-4 py-2 text-sm text-slate-600 hover:bg-surface">Panitia</a>
                    <a href="{{ route('juri.login') }}" class="block px-4 py-2 text-sm text-slate-600 hover:bg-surface">Juri</a>
                    <a href="{{ route('pimpinan.login') }}" class="block px-4 py-2 text-sm text-slate-600 hover:bg-surface">Pimpinan</a>
                    <a href="{{ route('admin.login') }}" class="block px-4 py-2 text-sm text-slate-600 hover:bg-surface">Admin</a>
                </div>
            </div>
        </div>
    </header>

    @yield('content')

    @include('layouts._footer', ['padding' => 'py-5'])

    <script>
        (function () {
            const tombol = document.getElementById('tombol-login');
            const menu = document.getElementById('menu-login');

            tombol.addEventListener('click', function (e) {
                e.stopPropagation();
                menu.classList.toggle('hidden');
            });
            document.addEventListener('click', function (e) {
                if (!menu.contains(e.target)) {
                    menu.classList.add('hidden');
                }
            });
        })();
    </script>
    @stack('skrip')
</body>
</html>