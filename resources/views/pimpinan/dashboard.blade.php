<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Pimpinan - TERANG NONA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-stone-50 min-h-screen">

    <nav class="bg-white border-b border-stone-200">
        <div class="max-w-4xl mx-auto px-4 py-3 flex flex-wrap items-center justify-between gap-2">
            <a href="{{ route('pimpinan.dashboard') }}">
                <img src="{{ asset('images/logo-terang-nona-transparan.png') }}" alt="TERANG NONA" class="h-10">
            </a>
            <div class="flex items-center gap-3">
                <span class="text-sm text-slate-500">Login sebagai: <strong class="text-slate-700">{{ $pimpinan->nama }}</strong></span>
                <form method="POST" action="{{ route('pimpinan.logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-slate-600 border border-stone-300 rounded-lg px-3 py-1.5 hover:bg-stone-100">Keluar</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto px-4 py-8">
        <h1 class="text-xl font-bold text-slate-900 mb-2">Dashboard Pimpinan</h1>
        <div class="bg-white border border-stone-200 rounded-xl p-6">
            <p class="text-slate-700">Login berhasil. Halaman ini bersifat hanya-lihat.</p>
            <p class="text-sm text-slate-500 mt-2">Ringkasan, ranking, dan daftar pengajuan akan ditambahkan pada tahap berikutnya.</p>
        </div>
    </main>

    <script src="{{ asset('js/prevent-double-submit.js') }}"></script>
</body>
</html>