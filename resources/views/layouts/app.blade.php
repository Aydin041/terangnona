<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - TERANG NONA</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="min-h-screen flex flex-col bg-surface font-sans text-ink antialiased">

    <header class="bg-brand-navy">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 py-3 flex flex-wrap items-center justify-between gap-x-6 gap-y-2">
            <div class="flex flex-wrap items-center gap-x-6 gap-y-2">
                <a href="@yield('beranda-url')" class="flex items-center gap-3 shrink-0">
                    <img src="{{ asset('images/logo-terang-nona-emas.png') }}" alt="TERANG NONA" class="h-10 w-auto">
                    <span class="text-white font-bold tracking-tight">TERANG NONA</span>
                </a>
                <span class="text-slate-400 text-sm">@yield('peran')</span>
                <nav class="flex flex-wrap items-center gap-x-5 gap-y-1 text-sm">
                    @yield('menu')
                </nav>
            </div>

            <div class="flex items-center gap-4 text-sm">
                <span class="text-slate-300 hidden sm:inline">Login sebagai: <strong class="text-white font-semibold">@yield('pengguna')</strong></span>
                <form method="POST" action="@yield('logout-url')">
                    @csrf
                    <button type="submit" class="text-slate-300 hover:text-white">Keluar</button>
                </form>
            </div>
        </div>
    </header>

    <main class="flex-1">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 py-8">
            @yield('content')
        </div>
    </main>

    <footer class="bg-brand-navy text-slate-300 text-sm text-center py-4 px-4">
        &copy; {{ date('Y') }} Dinas Tenaga Kerja dan Transmigrasi Provinsi Jawa Tengah
    </footer>

    <script src="{{ asset('js/prevent-double-submit.js') }}"></script>
</body>
</html>