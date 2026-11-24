<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - TERANG NONA</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ file_exists(public_path('css/app.css')) ? filemtime(public_path('css/app.css')) : time() }}">
</head>
<body class="min-h-screen flex flex-col bg-surface font-sans text-ink antialiased selection:bg-brand-amber selection:text-brand-navy">

    <header class="bg-brand-navy border-b border-white/10 sticky top-0 z-30 shadow-sm">
        <div class="@yield('lebar', 'max-w-5xl') mx-auto px-4 sm:px-6 py-3.5 flex flex-wrap items-center justify-between gap-x-6 gap-y-3">
            <div class="flex flex-wrap items-center gap-x-6 gap-y-2">
                <a href="@yield('beranda-url')" class="flex items-center gap-3 shrink-0 group">
                    <img src="{{ asset('images/logo-terang-nona-emas.png') }}" alt="TERANG NONA" class="h-9 w-auto transition-transform group-hover:scale-105">
                    <span class="text-white font-bold tracking-tight text-lg">TERANG NONA</span>
                </a>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-white/10 text-brand-amber border border-white/10">
                    @yield('peran')
                </span>
                <nav class="flex flex-wrap items-center @yield('jarak-menu', 'gap-x-5') gap-y-1 text-sm font-medium">
                    @yield('menu')
                </nav>
            </div>

            <div class="flex items-center gap-4 text-sm">
                <span class="text-slate-300 hidden sm:inline text-xs sm:text-sm">
                    Akun: <strong class="text-white font-semibold">@yield('pengguna')</strong>
                </span>
                <form method="POST" action="@yield('logout-url')">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-semibold text-slate-200 hover:text-white bg-white/5 hover:bg-white/10 border border-white/15 rounded-xl px-3.5 py-1.5 transition-colors">
                        <span>Keluar</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="flex-1">
        <div class="@yield('lebar', 'max-w-5xl') mx-auto px-4 sm:px-6 py-8 sm:py-10">
            @yield('content')
        </div>
    </main>

    @include('layouts._footer')

    <script src="{{ asset('js/prevent-double-submit.js') }}"></script>
</body>
</html>
