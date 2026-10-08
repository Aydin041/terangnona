<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Pimpinan - TERANG NONA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-stone-50 min-h-screen">

    @include('pimpinan._nav')

    <main class="max-w-4xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold text-slate-900 mb-1">Ringkasan Kompetisi</h1>
        <p class="text-sm text-slate-500 mb-6">Halaman ini bersifat hanya-lihat.</p>

        @php
            $kartu = [
                ['label' => 'Menunggu Pemeriksaan', 'kunci' => 'menunggu_pemeriksaan', 'warna' => 'text-sky-700'],
                ['label' => 'Disetujui', 'kunci' => 'disetujui', 'warna' => 'text-green-700'],
                ['label' => 'Perlu Perbaikan', 'kunci' => 'perlu_perbaikan', 'warna' => 'text-red-700'],
                ['label' => 'Ditolak', 'kunci' => 'ditolak', 'warna' => 'text-slate-800'],
            ];
        @endphp

        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mb-3">
            <div class="bg-white border border-stone-200 border-t-4 border-t-amber-500 rounded-xl p-4 col-span-2 sm:col-span-1">
                <p class="text-sm text-slate-500">Total Pengajuan Masuk</p>
                <p class="text-3xl font-bold text-slate-900 mt-1">{{ $totalMasuk }}</p>
            </div>
            @foreach ($kartu as $k)
                <a href="{{ route('pimpinan.pengajuan.index', ['status' => $k['kunci']]) }}"
                    class="bg-white border border-stone-200 hover:border-amber-400 rounded-xl p-4 transition-colors">
                    <p class="text-sm text-slate-500">{{ $k['label'] }}</p>
                    <p class="text-3xl font-bold mt-1 {{ $k['warna'] }}">{{ $jumlahPerStatus[$k['kunci']] ?? 0 }}</p>
                </a>
            @endforeach
        </div>
        <p class="text-xs text-slate-400 mb-8">Draft yang belum dikirim peserta ({{ $jumlahDraft }}) tidak dihitung.</p>

        <div class="grid sm:grid-cols-2 gap-3">
            <a href="{{ route('pimpinan.pengajuan.index') }}" class="block bg-white border border-stone-200 hover:border-amber-400 rounded-xl p-5 transition-colors">
                <p class="font-semibold text-slate-900">Daftar Pengajuan</p>
                <p class="text-sm text-slate-500 mt-1">Lihat pengajuan beserta isi proposalnya.</p>
            </a>
            <a href="{{ route('pimpinan.ranking.index') }}" class="block bg-white border border-stone-200 hover:border-amber-400 rounded-xl p-5 transition-colors">
                <p class="font-semibold text-slate-900">Ranking</p>
                <p class="text-sm text-slate-500 mt-1">Lihat peringkat proposal dan hasil akhir.</p>
            </a>
        </div>
    </main>

    <script src="{{ asset('js/prevent-double-submit.js') }}"></script>
</body>
</html>