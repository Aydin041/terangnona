<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Pengajuan - Panitia - TERANG NONA</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-stone-50 min-h-screen">

    <nav class="bg-white border-b border-stone-200">
        <div class="max-w-2xl mx-auto px-4 py-3 flex items-center justify-between flex-wrap gap-2">
            <a href="{{ route('panitia.dashboard') }}">
                <img src="{{ asset('images/logo-terang-nona-transparan.png') }}" alt="TERANG NONA" class="h-10">
            </a>
            <span class="text-sm text-slate-500">Login sebagai: <strong class="text-slate-700">{{ Auth::guard('panitia')->user()->nama }}</strong></span>
            <form method="POST" action="{{ route('panitia.logout') }}">
                @csrf
                <button type="submit" class="text-sm text-slate-600 hover:text-slate-900 border border-stone-300 rounded-lg px-3 py-1.5">Logout</button>
            </form>
        </div>
    </nav>

    <main class="max-w-2xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold text-slate-900 mb-1">Daftar Pengajuan</h1>
        <p class="mb-5"><a href="{{ route('panitia.ranking.index') }}" class="text-sm text-sky-700 hover:underline">Lihat Ranking Peserta →</a></p>

        @if (session('sukses'))
            <div class="mb-5 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm p-3">
                {{ session('sukses') }}
            </div>
        @endif

        @php
            $currentStatus = request('status');
            $filterClass = fn ($status) => $currentStatus === $status
                ? 'bg-slate-900 text-white'
                : 'bg-white text-slate-700 border border-stone-300 hover:bg-stone-100';
        @endphp
        <div class="flex flex-wrap gap-2 mb-6">
            <a href="{{ route('panitia.pengajuan.index') }}" class="text-sm rounded-lg px-3 py-1.5 {{ !$currentStatus ? 'bg-slate-900 text-white' : 'bg-white text-slate-700 border border-stone-300 hover:bg-stone-100' }}">Semua</a>
            <a href="{{ route('panitia.pengajuan.index', ['status' => 'menunggu_pemeriksaan']) }}" class="text-sm rounded-lg px-3 py-1.5 {{ $filterClass('menunggu_pemeriksaan') }}">Menunggu Pemeriksaan</a>
            <a href="{{ route('panitia.pengajuan.index', ['status' => 'disetujui']) }}" class="text-sm rounded-lg px-3 py-1.5 {{ $filterClass('disetujui') }}">Disetujui</a>
            <a href="{{ route('panitia.pengajuan.index', ['status' => 'perlu_perbaikan']) }}" class="text-sm rounded-lg px-3 py-1.5 {{ $filterClass('perlu_perbaikan') }}">Perlu Perbaikan</a>
            <a href="{{ route('panitia.pengajuan.index', ['status' => 'ditolak']) }}" class="text-sm rounded-lg px-3 py-1.5 {{ $filterClass('ditolak') }}">Ditolak</a>
        </div>

        @if ($daftarPengajuan->isEmpty())
            <div class="bg-white border border-stone-200 rounded-xl p-6 text-center text-slate-500">
                Tidak ada pengajuan.
            </div>
        @else
            @php
                $badge = [
                    'draft' => 'bg-amber-100 text-amber-800',
                    'menunggu_pemeriksaan' => 'bg-sky-100 text-sky-800',
                    'disetujui' => 'bg-green-100 text-green-800',
                    'perlu_perbaikan' => 'bg-red-100 text-red-800',
                    'ditolak' => 'bg-stone-800 text-white',
                ];
            @endphp
            <div class="space-y-3">
                @foreach ($daftarPengajuan as $item)
                    <a href="{{ route('panitia.pengajuan.detail', $item->id) }}"
                        class="block bg-white border border-stone-200 hover:border-amber-400 rounded-xl p-4 transition-colors">
                        <div class="flex items-start justify-between gap-3 flex-wrap">
                            <div>
                                <p class="font-medium text-slate-900">{{ $item->nama_inovasi }} ({{ $item->akronim }})</p>
                                <p class="text-sm text-slate-500">Peserta: {{ $item->peserta->nama }} | Kategori: {{ $item->kategori->nama }}</p>
                            </div>
                            <span class="text-xs font-medium px-2.5 py-1 rounded-full {{ $badge[$item->status] ?? 'bg-stone-100 text-stone-700' }}">{{ $item->status }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </main>

    <script src="{{ asset('js/prevent-double-submit.js') }}"></script>
</body>
</html>