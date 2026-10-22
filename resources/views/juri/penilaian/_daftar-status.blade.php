{{-- Parameter: $judul, $kosongTeks, $rutaDetail, $daftarPengajuan, $statusPenilaian --}}
<p class="mb-3"><a href="{{ route('juri.penilaian.index') }}" class="text-sm text-slate-500 hover:text-ink">← Kembali ke menu penilaian</a></p>
<h1 class="text-2xl font-bold mb-6">{{ $judul }}</h1>

@if (session('sukses'))
    <div class="mb-5 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm p-3">
        {{ session('sukses') }}
    </div>
@endif

@if ($daftarPengajuan->isEmpty())
    <div class="bg-white border border-line rounded-2xl p-8 text-center text-slate-500">
        {{ $kosongTeks }}
    </div>
@else
    @php
        $kelompokStatus = [
            'belum_dinilai' => ['label' => 'Belum Dinilai', 'dot' => 'bg-red-500'],
            'draft' => ['label' => 'Draft (belum disubmit)', 'dot' => 'bg-amber-500'],
            'submitted' => ['label' => 'Sudah Submit', 'dot' => 'bg-green-500'],
        ];
    @endphp

    <div class="space-y-8">
        @foreach ($kelompokStatus as $kunciStatus => $info)
            @php
                $itemDiKelompok = $daftarPengajuan->filter(fn ($item) => $statusPenilaian[$item->id] === $kunciStatus);
            @endphp

            <div>
                <h2 class="flex items-center gap-2 font-semibold mb-3">
                    <span class="w-2.5 h-2.5 rounded-full {{ $info['dot'] }}"></span>
                    {{ $info['label'] }} <span class="text-slate-400 font-normal">({{ count($itemDiKelompok) }})</span>
                </h2>

                @if ($itemDiKelompok->isEmpty())
                    <p class="text-sm text-slate-400 italic">Tidak ada.</p>
                @else
                    <div class="space-y-3">
                        @foreach ($itemDiKelompok as $item)
                            <a href="{{ route($rutaDetail, $item->id) }}"
                                class="block bg-white border border-line rounded-2xl p-5 hover:border-brand-amber transition-colors">
                                <p class="font-semibold">{{ $item->nama_inovasi }} ({{ $item->akronim }})</p>
                                <p class="text-sm text-slate-500 mt-0.5">Kategori: {{ $item->kategori->nama }} | Bentuk: {{ $item->bentuk_inovasi }}</p>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    </div>
@endif