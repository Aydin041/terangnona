<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Penilaian - Juri - TERANG NONA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-stone-50 min-h-screen">

    <nav class="bg-white border-b border-stone-200">
        <div class="max-w-2xl mx-auto px-4 py-3 flex items-center justify-between flex-wrap gap-2">
            <a href="{{ route('juri.dashboard') }}">
                <img src="{{ asset('images/logo-terang-nona-transparan.png') }}" alt="TERANG NONA" class="h-10">
            </a>
            <div class="flex items-center gap-3">
                <span class="text-sm text-slate-600">{{ Auth::guard('juri')->user()->nama }} <span class="text-slate-400">({{ Auth::guard('juri')->user()->email }})</span></span>
                <form method="POST" action="{{ route('juri.logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-slate-600 hover:text-slate-900 border border-stone-300 rounded-lg px-3 py-1.5">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-2xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold text-slate-900 mb-5">Daftar Penilaian</h1>

        @if (session('sukses'))
            <div class="mb-5 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm p-3">
                {{ session('sukses') }}
            </div>
        @endif

        <div class="grid sm:grid-cols-2 gap-4">
            <a href="{{ route('juri.penilaian.daftar.proposal') }}"
                class="bg-white border border-stone-200 hover:border-amber-400 rounded-xl p-6 transition-colors">
                <h2 class="font-semibold text-slate-900">Penilaian Proposal</h2>
                <p class="text-sm text-slate-500 mt-1">Semua pengajuan yang disetujui Panitia</p>
            </a>
            <a href="{{ route('juri.penilaian.daftar.presentasi') }}"
                class="bg-white border border-stone-200 hover:border-amber-400 rounded-xl p-6 transition-colors">
                <h2 class="font-semibold text-slate-900">Penilaian Presentasi</h2>
                <p class="text-sm text-slate-500 mt-1">Khusus pengajuan yang lolos 5 besar</p>
            </a>
        </div>
    </main>

    <script src="{{ asset('js/prevent-double-submit.js') }}"></script>
</body>
</html>