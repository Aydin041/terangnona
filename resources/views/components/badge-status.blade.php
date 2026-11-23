@props(['status'])

@php
    $peta = [
        'draft' => ['Draft', 'bg-amber-50 text-amber-800 border-amber-200/80'],
        'menunggu_pemeriksaan' => ['Menunggu Pemeriksaan', 'bg-sky-50 text-sky-800 border-sky-200/80'],
        'disetujui' => ['Disetujui', 'bg-emerald-50 text-emerald-800 border-emerald-200/80'],
        'perlu_perbaikan' => ['Perlu Perbaikan', 'bg-rose-50 text-rose-800 border-rose-200/80'],
        'ditolak' => ['Ditolak', 'bg-slate-100 text-slate-800 border-slate-300'],
    ];
    [$label, $kelas] = $peta[$status] ?? [$status, 'bg-slate-50 text-slate-700 border-slate-200'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold border shadow-2xs {$kelas}"]) }}>
    <span class="w-1.5 h-1.5 rounded-full mr-1.5 bg-current opacity-70"></span>
    {{ $label }}
</span>
