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
            <a href="{{ route('peserta.dashboard') }}">
                <img src="{{ asset('images/logo-terang-nona-transparan.png') }}" alt="TERANG NONA" class="h-10">
            </a>
            <span class="text-sm text-slate-500">Login sebagai: <strong class="text-slate-700">{{ Auth::guard('peserta')->user()->nama }}</strong></span>
            <form method="POST" action="{{ route('peserta.logout') }}">
                @csrf
                <button type="submit" class="text-sm text-slate-600 hover:text-slate-900 border border-stone-300 rounded-lg px-3 py-1.5">Logout</button>
            </form>
        </div>
    </nav>

    <main class="max-w-3xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold text-slate-900 mb-5">Dashboard Saya</h1>

        @if ($errors->any())
            <div class="mb-5 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm p-3">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

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
                            'ditolak' => 'bg-stone-800 text-white',
                        ][$item->status] ?? 'bg-stone-100 text-stone-700';
                    @endphp
                    <div class="bg-white border border-stone-200 rounded-xl p-5">
                        <div class="flex items-start justify-between gap-3 flex-wrap">
                            <h2 class="font-semibold text-slate-900">{{ $item->nama_inovasi }} ({{ $item->akronim }})</h2>
                            <span class="text-xs font-medium px-2.5 py-1 rounded-full {{ $badge }}">{{ $item->status }}</span>
                        </div>

                        @if ($item->status === 'draft')
                            <div class="mt-3 flex gap-2">
                                <a href="{{ route('peserta.pengajuan.step1.edit', $item->id) }}"
                                    class="inline-block bg-amber-500 hover:bg-amber-600 text-slate-900 text-sm font-semibold rounded-lg px-4 py-2 transition-colors">
                                    Lanjutkan Pengajuan
                                </a>
                                <form method="POST" action="{{ route('peserta.pengajuan.hapus', $item->id) }}"
                                    onsubmit="return confirm('Yakin mau hapus pengajuan draft ini? Tidak bisa dikembalikan.');">
                                    @csrf
                                    <button type="submit"
                                        class="border border-red-300 text-red-700 hover:bg-red-50 text-sm font-semibold rounded-lg px-4 py-2 transition-colors">
                                        Hapus
                                    </button>
                                </form>
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

        @if ($sudahLewatDeadline)
            <div class="mt-6 bg-stone-800 text-white rounded-lg px-5 py-3 text-sm">
                Sudah lewat deadline pengajuan — tidak bisa membuat pengajuan baru lagi.
            </div>
        @else
            <a href="{{ route('peserta.pengajuan.step1') }}"
                class="inline-block mt-6 bg-slate-900 hover:bg-slate-800 text-white font-semibold rounded-lg px-5 py-2.5 transition-colors">
                + Buat Pengajuan Baru
            </a>
        @endif
    </main>

    <script src="{{ asset('js/prevent-double-submit.js') }}"></script>
</body>
</html>