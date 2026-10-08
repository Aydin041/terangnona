@php
    $aktif = fn ($pola) => request()->routeIs($pola)
        ? 'bg-slate-900 text-white'
        : 'bg-white text-slate-700 border border-stone-300 hover:bg-stone-100';
@endphp
<nav class="bg-white border-b border-stone-200">
    <div class="max-w-4xl mx-auto px-4 py-3 flex flex-wrap items-center justify-between gap-3">
        <a href="{{ route('pimpinan.dashboard') }}">
            <img src="{{ asset('images/logo-terang-nona-transparan.png') }}" alt="TERANG NONA" class="h-10">
        </a>
        <div class="flex flex-wrap items-center gap-3">
            <span class="text-sm text-slate-500">Login sebagai: <strong class="text-slate-700">{{ Auth::guard('pimpinan')->user()->nama }}</strong></span>
            <form method="POST" action="{{ route('pimpinan.logout') }}">
                @csrf
                <button type="submit" class="text-sm text-slate-600 hover:text-slate-900 border border-stone-300 rounded-lg px-3 py-1.5">Keluar</button>
            </form>
        </div>
    </div>
    <div class="max-w-4xl mx-auto px-4 pb-3 flex flex-wrap gap-2">
        <a href="{{ route('pimpinan.dashboard') }}" class="text-sm rounded-lg px-3 py-1.5 {{ $aktif('pimpinan.dashboard') }}">Ringkasan</a>
        <a href="{{ route('pimpinan.pengajuan.index') }}" class="text-sm rounded-lg px-3 py-1.5 {{ $aktif('pimpinan.pengajuan.*') }}">Daftar Pengajuan</a>
        <a href="{{ route('pimpinan.ranking.index') }}" class="text-sm rounded-lg px-3 py-1.5 {{ $aktif('pimpinan.ranking.*') }}">Ranking</a>
    </div>
</nav>