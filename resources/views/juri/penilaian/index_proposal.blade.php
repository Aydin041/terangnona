<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Penilaian Proposal - Juri - TERANG NONA</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-stone-50 min-h-screen">

    <nav class="bg-white border-b border-stone-200">
        <div class="max-w-2xl mx-auto px-4 py-3 flex items-center justify-between flex-wrap gap-2">
            <a href="{{ route('juri.dashboard') }}">
                <img src="{{ asset('images/logo-terang-nona-transparan.png') }}" alt="TERANG NONA" class="h-10">
            </a>
            <span class="text-sm text-slate-600">{{ Auth::guard('juri')->user()->nama }} <span class="text-slate-400">({{ Auth::guard('juri')->user()->email }})</span></span>
        </div>
    </nav>

    <main class="max-w-2xl mx-auto px-4 py-8">
        <p class="mb-3"><a href="{{ route('juri.penilaian.index') }}" class="text-sm text-slate-500 hover:text-slate-900">← Kembali ke menu penilaian</a></p>
        <h1 class="text-2xl font-bold text-slate-900 mb-5">Penilaian Proposal</h1>

        @if (session('sukses'))
            <div class="mb-5 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm p-3">
                {{ session('sukses') }}
            </div>
        @endif

        @if ($daftarPengajuan->isEmpty())
            <div class="bg-white border border-stone-200 rounded-xl p-6 text-center text-slate-500">
                Belum ada pengajuan yang disetujui Panitia untuk dinilai.
            </div>
        @else
            @php
                $kelompokStatus = [
                    'belum_dinilai' => ['label' => 'Belum Dinilai', 'dot' => 'bg-red-500', 'badge' => 'bg-red-100 text-red-800'],
                    'draft' => ['label' => 'Draft (belum disubmit)', 'dot' => 'bg-amber-500', 'badge' => 'bg-amber-100 text-amber-800'],
                    'submitted' => ['label' => 'Sudah Submit', 'dot' => 'bg-green-500', 'badge' => 'bg-green-100 text-green-800'],
                ];
            @endphp

            <div class="space-y-8">
                @foreach ($kelompokStatus as $kunciStatus => $info)
                    @php
                        $itemDiKelompok = $daftarPengajuan->filter(fn ($item) => $statusPenilaian[$item->id] === $kunciStatus);
                    @endphp

                    <div>
                        <h3 class="flex items-center gap-2 font-semibold text-slate-900 mb-3">
                            <span class="w-2.5 h-2.5 rounded-full {{ $info['dot'] }}"></span>
                            {{ $info['label'] }} <span class="text-slate-400 font-normal">({{ count($itemDiKelompok) }})</span>
                        </h3>

                        @if ($itemDiKelompok->isEmpty())
                            <p class="text-sm text-slate-400 italic">Tidak ada.</p>
                        @else
                            <div class="space-y-3">
                                @foreach ($itemDiKelompok as $item)
                                    <a href="{{ route('juri.penilaian.proposal', $item->id) }}"
                                        class="block bg-white border border-stone-200 hover:border-amber-400 rounded-xl p-4 transition-colors">
                                        <p class="font-medium text-slate-900">{{ $item->nama_inovasi }} ({{ $item->akronim }})</p>
                                        <p class="text-sm text-slate-500">Kategori: {{ $item->kategori->nama }} | Bentuk: {{ $item->bentuk_inovasi }}</p>
                                    </a>
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