<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - Admin TERANG NONA</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ file_exists(public_path('css/app.css')) ? filemtime(public_path('css/app.css')) : time() }}">
</head>
<body class="min-h-screen flex flex-col md:flex-row bg-surface font-sans text-ink antialiased selection:bg-brand-amber selection:text-brand-navy">

    {{-- SIDEBAR ADMIN SAMPING --}}
    <aside class="w-full md:w-64 lg:w-72 bg-brand-navy flex flex-col justify-between shrink-0 md:sticky md:top-0 md:h-screen border-r border-white/10 z-40">
        <div>
            {{-- Brand / Header Sidebar --}}
            <div class="p-6 border-b border-white/10 flex items-center justify-between">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
                    <img src="{{ asset('images/logo-terang-nona-emas.png') }}" alt="TERANG NONA" class="h-9 w-auto transition-transform group-hover:scale-105">
                    <div>
                        <span class="text-white font-bold tracking-tight text-base block leading-tight">TERANG NONA</span>
                        <span class="text-2xs font-semibold uppercase tracking-wider text-brand-amber">Super Admin</span>
                    </div>
                </a>
            </div>

            {{-- Navigasi Menu Vertikal --}}
            @php
                $itemAktif = fn (...$pola) => request()->routeIs(...$pola)
                    ? 'bg-white/10 text-brand-amber font-bold shadow-xs border-r-4 border-brand-amber'
                    : 'text-slate-300 hover:bg-white/5 hover:text-white font-medium';
            @endphp
            <nav class="p-4 space-y-1.5 text-xs sm:text-sm">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ $itemAktif('admin.dashboard', 'admin.koreksi.*') }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span>Dashboard &amp; Koreksi</span>
                </a>
                <a href="{{ route('admin.pengajuan.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ $itemAktif('admin.pengajuan.*') }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span>Daftar Pengajuan</span>
                </a>
                <a href="{{ route('admin.laporan.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ $itemAktif('admin.laporan.*') }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    <span>Laporan Nilai</span>
                </a>
                <a href="{{ route('admin.ranking.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ $itemAktif('admin.ranking.*') }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                    <span>Klasemen Ranking</span>
                </a>
                <a href="{{ route('admin.survei.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ $itemAktif('admin.survei.*') }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/></svg>
                    <span>Hasil Survei</span>
                </a>
                <a href="{{ route('admin.akun.panitia.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ $itemAktif('admin.akun.*') }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    <span>Kelola Akun</span>
                </a>
                <a href="{{ route('admin.jadwal.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ $itemAktif('admin.jadwal.*') }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>Jadwal Kompetisi</span>
                </a>
                <a href="{{ route('admin.pengaturan.form') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ $itemAktif('admin.pengaturan.*') }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>Pengaturan Sistem</span>
                </a>
            </nav>
        </div>

        {{-- Profil Admin & Logout di Bagian Bawah Sidebar --}}
        <div class="p-4 border-t border-white/10 bg-black/10">
            <div class="flex items-center justify-between gap-2">
                <div class="truncate">
                    <p class="text-xs text-slate-400">Login Administrator:</p>
                    <p class="text-sm font-bold text-white truncate">{{ Auth::guard('admin')->user()->nama }}</p>
                </div>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" title="Keluar" class="p-2 rounded-xl text-slate-400 hover:text-white hover:bg-white/10 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- KONTEN UTAMA ADMIN --}}
    <div class="flex-1 flex flex-col min-w-0">
        {{-- Topbar Header Tipis --}}
        <header class="bg-white border-b border-slate-200/80 px-6 py-4 flex items-center justify-between gap-4 sticky top-0 z-30 shadow-2xs">
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-amber-50 text-brand-amber-dark border border-amber-200">
                    Administrator
                </span>
                <span class="text-slate-400 text-xs hidden sm:inline">&middot;</span>
                <span class="text-xs text-slate-500 hidden sm:inline">Disnakertrans Provinsi Jawa Tengah</span>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('landing') }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-brand-navy bg-slate-50 border border-slate-200/80 rounded-xl px-3 py-1.5 transition-colors">
                    <span>Lihat Web Publik</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>
            </div>
        </header>

        <main class="flex-1 p-6 sm:p-8 lg:p-10 max-w-7xl w-full">
            @yield('content')
        </main>

        @include('layouts._footer')
    </div>

    <script src="{{ asset('js/prevent-double-submit.js') }}"></script>
</body>
</html>
