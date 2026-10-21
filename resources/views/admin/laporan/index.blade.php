@extends('layouts.admin')

@section('title', 'Laporan Nilai')

@section('content')
    <h1 class="text-2xl font-bold">Laporan Nilai</h1>
    <p class="text-slate-500 mt-1 mb-6">Lihat-saja: semua nilai dari semua Juri untuk setiap pengajuan yang sudah dinilai. Tidak bisa diubah atau dihapus dari sini.</p>

    @if (empty($laporan))
        <div class="bg-white border border-line rounded-2xl p-8 text-center text-slate-500">
            Belum ada pengajuan yang dinilai.
        </div>
    @else
        <div class="space-y-5">
            @foreach ($laporan as $item)
                <div class="bg-white border border-line rounded-2xl p-6">
                    <h2 class="font-semibold">{{ $item['pengajuan']->nama_inovasi }} ({{ $item['pengajuan']->akronim }})</h2>
                    <p class="text-sm text-slate-500 mb-5">{{ $item['pengajuan']->kategori->nama ?? '-' }}</p>

                    @if ($item['proposal']->isNotEmpty())
                        <p class="text-sm font-semibold mb-2">Nilai Proposal</p>
                        <div class="space-y-3 mb-5">
                            @foreach ($item['proposal'] as $submisi)
                                <div class="bg-surface border border-line rounded-xl p-4 text-sm">
                                    <p class="font-semibold">
                                        {{ $submisi->juri->nama }}
                                        <span class="ml-1 text-xs font-medium px-2 py-0.5 rounded-full {{ $submisi->status === 'submitted' ? 'bg-green-100 text-green-800' : 'bg-amber-100 text-amber-800' }}">
                                            {{ $submisi->status === 'submitted' ? 'Sudah submit' : 'Draft' }}
                                        </span>
                                        @if ($submisi->submitted_at)
                                            <span class="text-xs font-normal text-slate-400">{{ \Carbon\Carbon::parse($submisi->submitted_at)->format('d M Y H:i') }}</span>
                                        @endif
                                    </p>
                                    <ul class="mt-2 text-slate-600 space-y-0.5">
                                        @foreach ($submisi->nilaiKomponen as $nk)
                                            <li>{{ $nk->komponen->nama }}: <strong class="text-ink font-semibold">{{ $nk->nilai ?? '-' }}</strong></li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if ($item['presentasi']->isNotEmpty())
                        <p class="text-sm font-semibold mb-2">Nilai Presentasi</p>
                        <div class="space-y-3">
                            @foreach ($item['presentasi'] as $submisi)
                                <div class="bg-surface border border-line rounded-xl p-4 text-sm">
                                    <p class="font-semibold">
                                        {{ $submisi->juri->nama }}
                                        <span class="ml-1 text-xs font-medium px-2 py-0.5 rounded-full {{ $submisi->status === 'submitted' ? 'bg-green-100 text-green-800' : 'bg-amber-100 text-amber-800' }}">
                                            {{ $submisi->status === 'submitted' ? 'Sudah submit' : 'Draft' }}
                                        </span>
                                        @if ($submisi->submitted_at)
                                            <span class="text-xs font-normal text-slate-400">{{ \Carbon\Carbon::parse($submisi->submitted_at)->format('d M Y H:i') }}</span>
                                        @endif
                                    </p>
                                    <ul class="mt-2 text-slate-600 space-y-0.5">
                                        @foreach ($submisi->nilaiAspek as $na)
                                            <li>{{ \App\Http\Controllers\Juri\PenilaianController::ASPEK_PRESENTASI[$na->aspek] ?? $na->aspek }}: <strong class="text-ink font-semibold">{{ $na->nilai ?? '-' }}</strong></li>
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
@endsection