{{-- Parameter: $kunci (panitia/juri/peserta/pimpinan), $peran (label), $daftar, $bolehTambah, $catatan (opsional), $tampilKontak (opsional) --}}
@include('admin.akun._tab')

<div class="flex items-start justify-between gap-4 flex-wrap mb-6">
    <div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-ink tracking-tight">Kelola Akun {{ $peran }}</h1>
        @isset($catatan)
            <p class="text-xs sm:text-sm text-slate-500 mt-1 max-w-xl leading-relaxed">{{ $catatan }}</p>
        @endisset
    </div>
    @if ($bolehTambah)
        <a href="{{ route('admin.akun.' . $kunci . '.create') }}"
            class="inline-flex items-center gap-2 bg-gradient-to-r from-brand-amber to-amber-500 hover:from-amber-400 hover:to-amber-500 text-brand-navy font-bold rounded-xl px-5 py-2.5 text-xs sm:text-sm transition-all duration-200 shadow-md shadow-amber-500/15 active:scale-95">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            <span>Tambah Akun {{ $peran }}</span>
        </a>
    @endif
</div>

@if ($errors->any())
    <div class="mb-6 rounded-2xl bg-red-50/80 border border-red-200 text-red-700 text-xs sm:text-sm p-4 font-medium">
        <ul class="list-disc list-inside space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('sukses'))
    <div class="mb-6 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm p-4 font-medium break-words">
        {{ session('sukses') }}
    </div>
@endif

@if ($daftar->isEmpty())
    <div class="bg-white border border-slate-200/80 rounded-3xl p-12 text-center shadow-sm">
        <div class="w-16 h-16 rounded-2xl bg-slate-50 border border-slate-200/60 flex items-center justify-center mx-auto mb-4 text-slate-400">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        </div>
        <h3 class="font-bold text-ink text-lg">Belum Ada Akun {{ $peran }}</h3>
        <p class="text-sm text-slate-500 mt-1">Daftar pengguna untuk peran ini masih kosong.</p>
    </div>
@else
    <div class="bg-white border border-slate-200/80 rounded-3xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/70 text-slate-400 text-xs uppercase tracking-wider">
                        <th class="py-3.5 px-5 font-bold">Nama Pengguna</th>
                        <th class="py-3.5 px-5 font-bold">Email &amp; Kontak</th>
                        <th class="py-3.5 px-5 font-bold text-right">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($daftar as $item)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="py-4 px-5 font-bold text-ink">
                                {{ $item->nama }}
                            </td>
                            <td class="py-4 px-5 text-slate-600">
                                <div class="font-medium">{{ $item->email }}</div>
                                @if (! empty($tampilKontak) && $item->kontak)
                                    <div class="text-xs text-slate-400 mt-0.5">{{ $item->kontak }}</div>
                                @endif
                            </td>
                            <td class="py-4 px-5 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.akun.' . $kunci . '.reset.form', $item->uuid) }}"
                                        class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-700 bg-white hover:bg-slate-50 border border-slate-200 rounded-xl px-3 py-1.5 transition-colors shadow-2xs">
                                        <svg class="w-3.5 h-3.5 text-brand-amber-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                                        <span>Reset Password</span>
                                    </a>
                                    <a href="{{ route('admin.akun.' . $kunci . '.hapus.form', $item->uuid) }}"
                                        class="inline-flex items-center gap-1.5 text-xs font-bold text-rose-600 bg-white hover:bg-rose-50 border border-rose-200 rounded-xl px-3 py-1.5 transition-colors shadow-2xs">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        <span>Hapus</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
