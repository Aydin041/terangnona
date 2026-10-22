{{-- Parameter: $langkah (1 sampai 5) --}}
@php
    $namaLangkah = [
        1 => 'Profil Inovasi',
        2 => 'Bentuk',
        3 => 'Ketua & Anggota',
        4 => 'Dokumen & Proposal',
        5 => 'Review & Submit',
    ];
@endphp

<ol class="grid grid-cols-5 gap-2 mb-3">
    @foreach ($namaLangkah as $nomor => $namaStep)
        @php
            $selesai = $nomor < $langkah;
            $sedang = $nomor === $langkah;
        @endphp
        <li class="flex flex-col items-center text-center gap-1.5">
            <span class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-semibold {{ $selesai ? 'bg-brand-blue text-white' : ($sedang ? 'bg-brand-amber text-brand-navy' : 'bg-line text-slate-500') }}">
                @if ($selesai) ✓ @else {{ $nomor }} @endif
            </span>
            <span class="hidden sm:block text-xs {{ $sedang ? 'text-ink font-semibold' : 'text-slate-500' }}">{{ $namaStep }}</span>
        </li>
    @endforeach
</ol>
<p class="sm:hidden text-sm text-slate-500 mb-4 text-center">Langkah {{ $langkah }} dari 5: {{ $namaLangkah[$langkah] }}</p>
<div class="mb-8"></div>