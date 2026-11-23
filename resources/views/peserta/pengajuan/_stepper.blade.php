{{-- Parameter: $langkah (1 sampai 5) --}}
@php
    $namaLangkah = [
        1 => 'Profil Inovasi',
        2 => 'Bentuk Inovasi',
        3 => 'Ketua & Anggota',
        4 => 'Dokumen & Proposal',
        5 => 'Review & Kirim',
    ];
@endphp

<div class="mb-8">
    {{-- Stepper Desktop --}}
    <div class="hidden sm:block">
        <ol class="flex items-center w-full">
            @foreach ($namaLangkah as $nomor => $namaStep)
                @php
                    $selesai = $nomor < $langkah;
                    $sedang = $nomor === $langkah;
                    $terakhir = $nomor === 5;
                @endphp
                <li class="flex items-center {{ $terakhir ? 'flex-none' : 'flex-1' }}">
                    <div class="flex items-center gap-2.5">
                        <span class="w-9 h-9 rounded-xl flex items-center justify-center text-xs font-bold transition-all shadow-2xs
                            {{ $selesai ? 'bg-brand-navy text-brand-amber' : ($sedang ? 'bg-gradient-to-r from-brand-amber to-amber-500 text-brand-navy font-extrabold ring-4 ring-amber-100' : 'bg-white border border-slate-200 text-slate-400') }}">
                            @if ($selesai)
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            @else
                                {{ $nomor }}
                            @endif
                        </span>
                        <span class="text-xs font-semibold whitespace-nowrap {{ $sedang ? 'text-brand-navy font-bold' : ($selesai ? 'text-slate-700' : 'text-slate-400') }}">
                            {{ $namaStep }}
                        </span>
                    </div>

                    @unless ($terakhir)
                        <div class="flex-1 h-0.5 mx-3 rounded-full {{ $selesai ? 'bg-brand-navy' : 'bg-slate-200' }}"></div>
                    @endunless
                </li>
            @endforeach
        </ol>
    </div>

    {{-- Stepper Mobile View (Progress Bar Minimalis) --}}
    <div class="sm:hidden bg-white border border-slate-200/80 rounded-2xl p-4 shadow-2xs">
        <div class="flex items-center justify-between text-xs font-bold mb-2">
            <span class="text-brand-amber-dark uppercase tracking-wider">Langkah {{ $langkah }} dari 5</span>
            <span class="text-ink">{{ $namaLangkah[$langkah] }}</span>
        </div>
        <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
            <div class="bg-gradient-to-r from-brand-amber to-amber-500 h-full rounded-full transition-all duration-300" style="width: {{ ($langkah / 5) * 100 }}%"></div>
        </div>
    </div>
</div>
