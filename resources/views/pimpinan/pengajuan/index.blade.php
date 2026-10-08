<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Pengajuan - Pimpinan - TERANG NONA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-stone-50 min-h-screen">

    @include('pimpinan._nav')

    <main class="max-w-4xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold text-slate-900 mb-1">Daftar Pengajuan</h1>
        <p class="text-sm text-slate-500 mb-5">Hanya-lihat. Pengajuan yang masih draft tidak ditampilkan.</p>

        @php
            $filterClass = fn ($nilai) => $status === $nilai
                ? 'bg-slate-900 text-white'
                : 'bg-white text-slate-700 border border-stone-300 hover:bg-stone-100';
            $badge = [
                'menunggu_pemeriksaan' => ['Menunggu Pemeriksaan', 'bg-sky-100 text-sky-800'],
                'disetujui' => ['Disetujui', 'bg-green-100 text-green-800'],
                'perlu_perbaikan' => ['Perlu Perbaikan', 'bg-red-100 text-red-800'],
                'ditolak' => ['Ditolak', 'bg-stone-800 text-white'],
            ];
        @endphp

        <div class="flex flex-wrap gap-2 mb-6">
            <a href="{{ route('pimpinan.pengajuan.index') }}" class="text-sm rounded-lg px-3 py-1.5 {{ $status === null ? 'bg-slate-900 text-white' : 'bg-white text-slate-700 border border-stone-300 hover:bg-stone-100' }}">Semua</a>
            <a href="{{ route('pimpinan.pengajuan.index', ['status' => 'menunggu_pemeriksaan']) }}" class="text-sm rounded-lg px-3 py-1.5 {{ $filterClass('menunggu_pemeriksaan') }}">Menunggu Pemeriksaan</a>
            <a href="{{ route('pimpinan.pengajuan.index', ['status' => 'disetujui']) }}" class="text-sm rounded-lg px-3 py-1.5 {{ $filterClass('disetujui') }}">Disetujui</a>
            <a href="{{ route('pimpinan.pengajuan.index', ['status' => 'perlu_perbaikan']) }}" class="text-sm rounded-lg px-3 py-1.5 {{ $filterClass('perlu_perbaikan') }}">Perlu Perbaikan</a>
            <a href="{{ route('pimpinan.pengajuan.index', ['status' => 'ditolak']) }}" class="text-sm rounded-lg px-3 py-1.5 {{ $filterClass('ditolak') }}">Ditolak</a>
        </div>

        @if ($daftarPengajuan->isEmpty())
            <div class="bg-white border border-stone-200 rounded-xl p-6 text-center text-slate-500">
                Tidak ada pengajuan.
            </div>
        @else
            <div class="space-y-3">
                @foreach ($daftarPengajuan as $item)
                    @php [$labelStatus, $kelasStatus] = $badge[$item->status] ?? [$item->status, 'bg-stone-100 text-stone-700']; @endphp
                    <a href="{{ route('pimpinan.pengajuan.detail', $item->id) }}"
                        class="block bg-white border border-stone-200 hover:border-amber-400 rounded-xl p-4 transition-colors">
                        <div class="flex items-start justify-between gap-3 flex-wrap">
                            <div class="min-w-0">
                                <p class="font-medium text-slate-900">{{ $item->nama_inovasi }} ({{ $item->akronim }})</p>
                                <p class="text-sm text-slate-500">Peserta: {{ $item->peserta->nama }} | Kategori: {{ $item->kategori->nama }}</p>
                            </div>
                            <span class="text-xs font-medium px-2.5 py-1 rounded-full {{ $kelasStatus }}">{{ $labelStatus }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </main>

    <script src="{{ asset('js/prevent-double-submit.js') }}"></script>
</body>
</html>