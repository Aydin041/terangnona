@props(['status'])

@php
    $peta = [
        'draft' => ['Draft', 'bg-amber-100 text-amber-800'],
        'menunggu_pemeriksaan' => ['Menunggu Pemeriksaan', 'bg-sky-100 text-sky-800'],
        'disetujui' => ['Disetujui', 'bg-green-100 text-green-800'],
        'perlu_perbaikan' => ['Perlu Perbaikan', 'bg-red-100 text-red-800'],
        'ditolak' => ['Ditolak', 'bg-ink text-white'],
    ];
    [$label, $kelas] = $peta[$status] ?? [$status, 'bg-slate-100 text-slate-700'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {$kelas}"]) }}>{{ $label }}</span>