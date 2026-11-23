<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - TERANG NONA</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="min-h-screen flex flex-col bg-surface font-sans text-ink antialiased selection:bg-brand-amber selection:text-brand-navy">

    <main class="flex-1 grid lg:grid-cols-12 min-h-screen">
        {{-- Panel Kiri (Layar Desktop): Branding Elegan --}}
        <div class="hidden lg:flex lg:col-span-5 xl:col-span-6 flex-col justify-between p-12 bg-brand-navy bg-[radial-gradient(ellipse_at_30%_20%,#1a3672_0%,#0a1431_75%)] relative overflow-hidden text-white">
            <div class="absolute -right-20 -bottom-20 w-96 h-96 bg-brand-amber/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10">
                <a href="{{ route('landing') }}" class="inline-flex items-center gap-3 group">
                    <img src="{{ asset('images/logo-terang-nona-emas.png') }}" alt="TERANG NONA" class="h-10 w-auto transition-transform group-hover:scale-105">
                    <span class="text-white font-bold tracking-tight text-xl">TERANG NONA</span>
                </a>
            </div>

            <div class="relative z-10 max-w-md my-auto py-12">
                <span class="inline-block px-3 py-1 rounded-full bg-white/10 text-brand-amber text-xs font-semibold uppercase tracking-wider mb-4 border border-white/10">
                    Portal Terpadu
                </span>
                <h2 class="text-3xl xl:text-4xl font-extrabold leading-tight text-white mb-4">
                    Inovasi Ketenagakerjaan &amp; Ketransmigrasian Jawa Tengah
                </h2>
                <p class="text-slate-300 text-sm leading-relaxed">
                    Sistem partisipasi, seleksi, dan evaluasi inovasi resmi Dinas Tenaga Kerja dan Transmigrasi Provinsi Jawa Tengah.
                </p>
            </div>

            <div class="relative z-10 text-xs text-slate-400 border-t border-white/10 pt-4">
                &copy; {{ date('Y') }} Disnakertrans Jateng &middot; Ngopeni lan Nglakoni
            </div>
        </div>

        {{-- Panel Kanan: Form Card Modern --}}
        <div class="lg:col-span-7 xl:col-span-6 flex items-center justify-center p-6 sm:p-10 lg:p-12">
            <div class="w-full max-w-md">
                {{-- Logo untuk Mobile View --}}
                <div class="lg:hidden text-center mb-8">
                    <a href="{{ route('landing') }}" class="inline-block group">
                        <img src="{{ asset('images/logo-terang-nona-transparan.png') }}" alt="TERANG NONA" class="h-16 mx-auto transition-transform group-hover:scale-105">
                    </a>
                </div>

                <div class="bg-white border border-slate-200/80 rounded-3xl p-7 sm:p-9 shadow-sm hover:shadow-md transition-shadow">
                    @yield('content')
                </div>

                <div class="text-center mt-6">
                    <a href="{{ route('landing') }}" class="text-xs sm:text-sm font-semibold text-slate-500 hover:text-brand-navy transition-colors inline-flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Kembali ke Halaman Utama
                    </a>
                </div>
            </div>
        </div>
    </main>

    @include('layouts._footer')

    <script src="{{ asset('js/prevent-double-submit.js') }}"></script>
</body>
</html>
