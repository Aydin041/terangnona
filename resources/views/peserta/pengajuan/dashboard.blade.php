<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Saya - TERANG NONA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-stone-50 min-h-screen">

    <nav class="bg-white border-b border-stone-200">
        <div class="max-w-3xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="{{ route('landing') }}">
                <img src="{{ asset('images/logo-terang-nona-transparan.png') }}" alt="TERANG NONA" class="h-10">
            </a>
            <form method="POST" action="{{ route('peserta.logout') }}">
                @csrf
                <button type="submit" class="text-sm text-slate-600 hover:text-slate-900 border border-stone-300 rounded-lg px-3 py-1.5">Logout</button>
            </form>
        </div>
    </nav>

    <main class="max-w-3xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold text-slate-900 mb-5">Dashboard Saya</h1>

        @if (session('sukses'))
            <div class="mb-5 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm p-3">
                {{ session('sukses') }}
            </div>
        @endif

        @if ($daftarPengajuan->isEmpty())
            <div class="bg-white border border-stone-200 rounded-xl p-6 text-center text-slate-500">
                Belum ada pengajuan. Mulai pengajuan baru untuk mengikuti TERANG NONA 2026.
            </div>
        @else
            <div class="space-y-4">
                @foreach ($daftarPengajuan as $item)
                    @php
                        $badge = [
                            'draft' => 'bg-amber-100 text-amber-800',
                            'menunggu_pemeriksaan' => 'bg-sky-100 text-sky-800',
                            'disetujui' => 'bg-green-100 text-green-800',
                            'perlu_perbaikan' => 'bg-red-100 text-red-800',
                        ][$item->status] ?? 'bg-stone-100 text-stone-700';
                    @endphp
                    <div class="bg-white border border-stone-200 rounded-xl p-5">
                        <div class="flex items-start justify-between gap-3 flex-wrap">
                            <h2 class="font-semibold text-slate-900">{{ $item->nama_inovasi }} ({{ $item->akronim }})</h2>
                            <span class="text-xs font-medium px-2.5 py-1 rounded-full {{ $badge }}">{{ $item->status }}</span>
                        </div>

                        @if ($item->status === 'draft')
                            <div class="mt-3">
                                <a href="{{ route('peserta.pengajuan.step1.edit', $item->id) }}"
                                    class="inline-block bg-amber-500 hover:bg-amber-600 text-slate-900 text-sm font-semibold rounded-lg px-4 py-2 transition-colors">
                                    Lanjutkan Pengajuan
                                </a>
                            </div>
                        @endif

                        @if ($item->link_presentasi)
                            <div class="mt-3 bg-sky-50 border border-sky-200 rounded-lg p-3 text-sm">
                                <strong class="text-sky-900">Link Zoom/Meet Presentasi:</strong>
                                <a href="{{ $item->link_presentasi }}" target="_blank" class="text-sky-700 underline break-all">{{ $item->link_presentasi }}</a>
                            </div>
                        @endif

                        @if ($item->status === 'perlu_perbaikan')
                            <div class="mt-3 bg-red-50 border border-red-200 rounded-lg p-3 text-sm">
                                <strong class="text-red-800">Alasan dari Panitia:</strong>
                                <p class="text-red-700 mt-1">{{ $catatanPengembalian[$item->id] ?? '(tidak ada catatan)' }}</p>
                                <a href="{{ route('peserta.pengajuan.step1.edit', $item->id) }}"
                                    class="inline-block mt-2 bg-amber-500 hover:bg-amber-600 text-slate-900 text-sm font-semibold rounded-lg px-4 py-2 transition-colors">
                                    Perbaiki Pengajuan Ini
                                </a>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

        <a href="{{ route('peserta.pengajuan.step1') }}"
            class="inline-block mt-6 bg-slate-900 hover:bg-slate-800 text-white font-semibold rounded-lg px-5 py-2.5 transition-colors">
            + Buat Pengajuan Baru
        </a>
    </main>

    <script src="{{ asset('js/prevent-double-submit.js') }}"></script>
</body>
</html>