<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Panitia - TERANG NONA 2026</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-stone-50 min-h-screen">

    <nav class="bg-white border-b border-stone-200">
        <div class="max-w-2xl mx-auto px-4 py-3 flex items-center justify-between flex-wrap gap-2">
            <a href="{{ route('landing') }}">
                <img src="{{ asset('images/logo-terang-nona-transparan.png') }}" alt="TERANG NONA" class="h-10">
            </a>
            <form method="POST" action="{{ route('panitia.logout') }}">
                @csrf
                <button type="submit" class="text-sm text-slate-600 hover:text-slate-900 border border-stone-300 rounded-lg px-3 py-1.5">Logout</button>
            </form>
        </div>
    </nav>

    <main class="max-w-2xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold text-slate-900 mb-2">Dashboard Panitia</h1>
        <p class="text-slate-500 mb-6">Selamat datang, {{ Auth::guard('panitia')->user()->nama }}.</p>

        <div class="grid sm:grid-cols-2 gap-4">
            <a href="{{ route('panitia.pengajuan.index') }}"
                class="bg-white border border-stone-200 hover:border-amber-400 rounded-xl p-6 transition-colors">
                <h2 class="font-semibold text-slate-900">Daftar Pengajuan</h2>
                <p class="text-sm text-slate-500 mt-1">Periksa dan setujui pengajuan peserta</p>
            </a>
            <a href="{{ route('panitia.ranking.index') }}"
                class="bg-white border border-stone-200 hover:border-amber-400 rounded-xl p-6 transition-colors">
                <h2 class="font-semibold text-slate-900">Ranking Peserta</h2>
                <p class="text-sm text-slate-500 mt-1">Lihat ranking proposal & presentasi</p>
            </a>
        </div>
    </main>

    <script src="{{ asset('js/prevent-double-submit.js') }}"></script>
</body>
</html>