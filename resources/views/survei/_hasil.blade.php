{{-- Hasil survei (gabungan). Tidak pernah memuat identitas.
     Butuh: $ringkasan, $jumlahLayak. Opsional: $tautanPartisipasi (hanya untuk Admin) --}}
@php
    $jumlah = $ringkasan['jumlah'];
    $persen = fn ($n) => $jumlah > 0 ? round($n / $jumlah * 100) : 0;
    $tahunSurvei = \App\Models\TahapJadwal::tahun();
@endphp

<div class="bg-white border border-line rounded-2xl p-6 mb-4">
    <p class="text-sm text-slate-500">Responden</p>
    <p class="mt-1"><span class="text-3xl font-bold">{{ $jumlah }}</span> <span class="text-sm text-slate-500">dari {{ $jumlahLayak }} peserta</span></p>

    @isset($tautanPartisipasi)
        <a href="{{ $tautanPartisipasi }}" class="inline-block mt-3 text-sm font-semibold text-brand-blue hover:underline">
            Lihat siapa yang sudah mengisi &rarr;
        </a>
    @endisset
</div>

@if ($jumlah === 0)
    <div class="bg-white border border-line rounded-2xl p-6 mb-4 text-sm text-slate-500">
        Belum ada responden. Hasil akan tampil di sini setelah peserta mulai mengisi survei.
    </div>
@endif

<div class="bg-white border border-line rounded-2xl p-6 mb-4">
    <h2 class="font-semibold">1. Seberapa baik penyelenggaraan kompetisi TERANG NONA {{ $tahunSurvei }}?</h2>

    <div class="flex items-baseline gap-3 flex-wrap mt-3 mb-4">
        <span class="text-3xl font-bold text-brand-blue">{{ $ringkasan['rata'] !== null ? number_format($ringkasan['rata'], 1, ',', '.') : '-' }}</span>
        <span class="text-sm text-slate-500">rata-rata dari 5 &middot; 1 = Kurang Baik, 5 = Baik Sekali</span>
    </div>

    <div class="space-y-2">
        @foreach ($ringkasan['distribusi'] as $nilai => $banyak)
            <div class="flex items-center gap-3 text-sm">
                <span class="w-4 text-slate-500">{{ $nilai }}</span>
                <div class="flex-1 rounded-full overflow-hidden" style="background:#e1e6f0;height:8px">
                    <div style="width:{{ $persen($banyak) }}%;height:8px;background:#f5a31a;border-radius:9999px"></div>
                </div>
                <span class="w-8 text-right text-slate-500">{{ $banyak }}</span>
            </div>
        @endforeach
    </div>
</div>

<div class="bg-white border border-line rounded-2xl p-6 mb-4">
    <h2 class="font-semibold">2. Aspek apa saja yang perlu ditingkatkan pada penyelenggaraan kompetisi TERANG NONA?</h2>
    <p class="text-sm text-slate-500 mt-0.5 mb-4">Jumlah peserta yang memilih tiap aspek (boleh memilih lebih dari satu).</p>

    <div class="space-y-3">
        @foreach ($ringkasan['aspek'] as $label => $banyak)
            <div class="flex items-center gap-3 text-sm flex-wrap">
                <span class="sm:w-60 w-full">{{ $label }}</span>
                <div class="flex-1 rounded-full overflow-hidden" style="background:#e1e6f0;height:8px;min-width:120px">
                    <div style="width:{{ $persen($banyak) }}%;height:8px;background:#2b8bc6;border-radius:9999px"></div>
                </div>
                <span class="w-8 text-right text-slate-500">{{ $banyak }}</span>
            </div>
        @endforeach
    </div>
</div>

<h2 class="font-semibold mt-6">3. Tuliskan saran dan masukan Anda untuk pengembangan penyelenggaraan kompetisi TERANG NONA di masa mendatang.</h2>
<p class="text-sm text-slate-500 mt-0.5 mb-3">Jawaban teks dari semua peserta, tanpa nama dan diurutkan abjad.</p>

<div class="space-y-3">
    @forelse ($ringkasan['saran'] as $teks)
        <div class="bg-white border border-line rounded-2xl p-5">
            <p class="text-sm whitespace-pre-line break-words">{{ $teks }}</p>
            <p class="text-xs text-slate-400 mt-1">Anonim</p>
        </div>
    @empty
        <div class="bg-white border border-line rounded-2xl p-5 text-sm text-slate-500">Belum ada saran.</div>
    @endforelse
</div>