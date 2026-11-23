@php
    $tabAkun = ['panitia' => 'Panitia', 'juri' => 'Juri', 'peserta' => 'Peserta', 'pimpinan' => 'Pimpinan'];
@endphp
<div class="flex flex-wrap gap-2 mb-6">
    @foreach ($tabAkun as $kunciTab => $labelTab)
        @php
            $isAktif = request()->routeIs('admin.akun.' . $kunciTab . '.*');
        @endphp
        <a href="{{ route('admin.akun.' . $kunciTab . '.index') }}"
            class="text-xs sm:text-sm font-bold rounded-xl border px-4 py-2 transition-all duration-200 shadow-2xs {{ $isAktif ? 'bg-brand-navy text-white border-brand-navy shadow-sm' : 'bg-white text-slate-600 border-slate-200 hover:border-brand-amber hover:text-brand-navy' }}">
            Akun {{ $labelTab }}
        </a>
    @endforeach
</div>
