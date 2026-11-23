{{-- Hasil survei (gabungan). Tidak pernah memuat identitas.
     Butuh: $ringkasan, $jumlahLayak. Opsional: $tautanPartisipasi (hanya untuk Admin) --}}
@php
    $jumlah = $ringkasan['jumlah'];
    $persen = fn ($n) => $jumlah > 0 ? round($n / $jumlah * 100) : 0;
    $tahunSurvei = \App\Models\TahapJadwal::tahun();
@endphp

{{-- Kartu Partisipasi Responden --}}
<div class="bg-gradient-to-r from-brand-navy to-brand-navy-soft rounded-3xl p-7 text-white shadow-sm mb-6 flex items-center justify-between gap-4 flex-wrap">
    <div>
        <span class="inline-block text-xs font-bold uppercase tracking-wider text-brand-amber bg-white/10 px-3 py-1 rounded-full mb-2 border border-white/10">Responden Survei</span>
        <p class="text-slate-300 text-sm">Tingkat Partisipasi Peserta</p>
        <div class="flex items-baseline gap-2 mt-1">
            <span class="text-3xl sm:text-4xl font-black text-white">{{ $jumlah }}</span>
            <span class="text-sm text-slate-300">dari total {{ $jumlahLayak }} peserta yang berhak mengisi</span>
        </div>
    </div>
    @isset($tautanPartisipasi)
        <a href="{{ $tautanPartisipasi }}" class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-bold text-white bg-white/10 hover:bg-white/20 border border-white/20 rounded-xl px-4 py-2 transition-colors">
            <span>Daftar Peserta Pengisi</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
    @endisset
</div>

@if ($jumlah === 0)
    <div class="bg-white border border-slate-200/80 rounded-3xl p-12 text-center text-slate-500 shadow-sm mb-6">
        <p class="font-bold text-ink text-base">Belum Ada Responden</p>
        <p class="text-xs sm:text-sm text-slate-400 mt-1">Grafik dan persentase akan terisi otomatis setelah peserta mengirimkan survei.</p>
    </div>
@endif

{{-- Pertanyaan 1: Skala Kepuasan --}}
<div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-8 shadow-sm mb-6">
    <div class="flex items-center gap-2 mb-1">
        <span class="w-2.5 h-2.5 rounded-full bg-brand-amber"></span>
        <h2 class="font-bold text-ink text-base sm:text-lg">1. Seberapa baik penyelenggaraan kompetisi TERANG NONA {{ $tahunSurvei }}?</h2>
    </div>

    <div class="flex gap-4 items-baseline flex-wrap mt-4 mb-6 p-4 rounded-2xl bg-amber-50/50 border border-amber-200/60">
        <span class="text-4xl font-black text-brand-navy">{{ $ringkasan['rata'] !== null ? number_format($ringkasan['rata'], 1, ',', '.') : '-' }}</span>
        <div class="text-xs sm:text-sm text-slate-600">
            <span class="font-bold text-ink">Skor Indeks Kepuasan (Skala 1 - 5)</span>
            <span class="block text-slate-400 text-xs mt-0.5">1 = Sangat Kurang &middot; 5 = Sangat Memuaskan</span>
        </div>
    </div>

    <div class="space-y-3">
        @foreach ($ringkasan['distribusi'] as $nilai => $banyak)
            <div class="flex items-center gap-3 text-xs sm:text-sm">
                <span class="font-bold text-slate-700 w-8">Bintang {{ $nilai }}</span>
                <div class="flex-1 bg-slate-100 h-3 rounded-full overflow-hidden">
                    <div class="bg-gradient-to-r from-brand-amber to-amber-500 h-full rounded-full transition-all duration-300" style="width: {{ $persen($banyak) }}%"></div>
                </div>
                <span class="w-16 text-right font-bold text-slate-700">{{ $banyak }} ({{ $persen($banyak) }}%)</span>
            </div>
        @endforeach
    </div>
</div>

{{-- Pertanyaan 2: Aspek yang Perlu Ditingkatkan --}}
<div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-8 shadow-sm mb-6">
    <div class="flex items-center gap-2 mb-1">
        <span class="w-2.5 h-2.5 rounded-full bg-brand-blue"></span>
        <h2 class="font-bold text-ink text-base sm:text-lg">2. Aspek yang Perlu Ditingkatkan</h2>
    </div>
    <p class="text-xs sm:text-sm text-slate-500 mb-6">Distribusi pilihan responden (peserta diperbolehkan memilih lebih dari satu aspek).</p>

    <div class="space-y-3.5">
        @foreach ($ringkasan['aspek'] as $label => $banyak)
            <div class="flex items-center gap-3 text-xs sm:text-sm flex-wrap sm:flex-nowrap">
                <span class="w-full sm:w-60 font-semibold text-ink shrink-0">{{ $label }}</span>
                <div class="flex-1 bg-slate-100 h-3 rounded-full overflow-hidden w-full sm:w-auto">
                    <div class="bg-gradient-to-r from-brand-blue to-brand-blue-light h-full rounded-full transition-all duration-300" style="width: {{ $persen($banyak) }}%"></div>
                </div>
                <span class="w-16 text-right font-bold text-slate-700 shrink-0">{{ $banyak }} respon</span>
            </div>
        @endforeach
    </div>
</div>

{{-- Pertanyaan 3: Saran & Masukan Kualitatif --}}
<div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-8 shadow-sm mb-6">
    <div class="flex items-center gap-2 mb-1">
        <span class="w-2.5 h-2.5 rounded-full bg-emerald-600"></span>
        <h2 class="font-bold text-ink text-base sm:text-lg">3. Kritik, Saran, &amp; Masukan Inovator</h2>
    </div>
    <p class="text-xs sm:text-sm text-slate-500 mb-6">Umpan balik terbuka untuk pengembangan penyelenggaraan TERANG NONA masa depan (Anonim).</p>

    <div class="space-y-3">
        @forelse ($ringkasan['saran'] as $teks)
            <div class="bg-slate-50 border border-slate-200/70 rounded-2xl p-4 sm:p-5">
                <p class="text-xs sm:text-sm text-slate-700 leading-relaxed whitespace-pre-line">{{ $teks }}</p>
                <div class="flex items-center gap-2 mt-3 pt-2.5 border-t border-slate-200/50 text-2xs text-slate-400 font-semibold uppercase tracking-wider">
                    <span>Inovator Peserta &middot; Masukan Anonim</span>
                </div>
            </div>
        @empty
            <div class="text-center py-6 text-slate-400 text-xs sm:text-sm italic">Belum ada saran teks yang masuk.</div>
        @endforelse
    </div>
</div>
