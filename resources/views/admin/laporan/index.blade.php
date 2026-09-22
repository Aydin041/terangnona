<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Nilai - Admin - TERANG NONA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-stone-50 min-h-screen">

    <nav class="bg-white border-b border-stone-200">
        <div class="max-w-2xl mx-auto px-4 py-3">
            <a href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('images/logo-terang-nona-transparan.png') }}" alt="TERANG NONA" class="h-10">
            </a>
            <span class="text-sm text-slate-500">Login sebagai: <strong class="text-slate-700">{{ Auth::guard('admin')->user()->nama }}</strong></span>
        </div>
    </nav>

    <main class="max-w-2xl mx-auto px-4 py-8">
        <p class="mb-3"><a href="{{ route('admin.dashboard') }}" class="text-sm text-slate-500 hover:text-slate-900">← Dashboard</a></p>
        <h1 class="text-2xl font-bold text-slate-900 mb-1">Laporan Nilai</h1>
        <p class="text-sm text-slate-500 mb-6">Lihat-saja — semua nilai dari semua Juri untuk setiap pengajuan yang sudah dinilai. Tidak bisa diubah/dihapus dari sini.</p>

        @if (empty($laporan))
            <div class="bg-white border border-stone-200 rounded-xl p-6 text-center text-slate-500">
                Belum ada pengajuan yang dinilai.
            </div>
        @else
            <div class="space-y-6">
                @foreach ($laporan as $item)
                    <div class="bg-white border border-stone-200 rounded-xl p-5">
                        <h2 class="font-semibold text-slate-900">{{ $item['pengajuan']->nama_inovasi }} ({{ $item['pengajuan']->akronim }})</h2>
                        <p class="text-sm text-slate-500 mb-4">{{ $item['pengajuan']->kategori->nama ?? '-' }}</p>

                        @if ($item['proposal']->isNotEmpty())
                            <p class="font-medium text-slate-800 text-sm mb-2">Nilai Proposal</p>
                            <div class="space-y-3 mb-4">
                                @foreach ($item['proposal'] as $submisi)
                                    <div class="bg-stone-50 border border-stone-200 rounded-lg p-3 text-sm">
                                        <p class="font-medium text-slate-900">
                                            {{ $submisi->juri->nama }}
                                            <span class="text-xs font-normal text-slate-400">
                                                — {{ $submisi->status }}
                                                @if ($submisi->submitted_at)
                                                    , disubmit {{ \Carbon\Carbon::parse($submisi->submitted_at)->format('d M Y H:i') }}
                                                @endif
                                            </span>
                                        </p>
                                        <ul class="mt-1 text-slate-600">
                                            @foreach ($submisi->nilaiKomponen as $nk)
                                                <li>{{ $nk->komponen->nama }}: <strong class="text-slate-900">{{ $nk->nilai ?? '-' }}</strong></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @if ($item['presentasi']->isNotEmpty())
                            <p class="font-medium text-slate-800 text-sm mb-2">Nilai Presentasi</p>
                            <div class="space-y-3">
                                @foreach ($item['presentasi'] as $submisi)
                                    <div class="bg-stone-50 border border-stone-200 rounded-lg p-3 text-sm">
                                        <p class="font-medium text-slate-900">
                                            {{ $submisi->juri->nama }}
                                            <span class="text-xs font-normal text-slate-400">
                                                — {{ $submisi->status }}
                                                @if ($submisi->submitted_at)
                                                    , disubmit {{ \Carbon\Carbon::parse($submisi->submitted_at)->format('d M Y H:i') }}
                                                @endif
                                            </span>
                                        </p>
                                        <ul class="mt-1 text-slate-600">
                                            @foreach ($submisi->nilaiAspek as $na)
                                                <li>{{ \App\Http\Controllers\Juri\PenilaianController::ASPEK_PRESENTASI[$na->aspek] ?? $na->aspek }}: <strong class="text-slate-900">{{ $na->nilai ?? '-' }}</strong></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </main>

</body>
</html>