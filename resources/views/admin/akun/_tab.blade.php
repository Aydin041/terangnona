@php
    $tabAkun = ['panitia' => 'Panitia', 'juri' => 'Juri', 'peserta' => 'Peserta', 'pimpinan' => 'Pimpinan'];
@endphp
<div class="flex flex-wrap gap-2 mb-6">
    @foreach ($tabAkun as $kunciTab => $labelTab)
        <a href="{{ route('admin.akun.' . $kunciTab . '.index') }}"
            class="text-sm font-medium rounded-full border px-4 py-1.5 transition-colors {{ request()->routeIs('admin.akun.' . $kunciTab . '.*') ? 'bg-brand-navy text-white border-brand-navy' : 'bg-white text-slate-700 border-line hover:border-brand-amber' }}">
            Akun {{ $labelTab }}
        </a>
    @endforeach
</div>