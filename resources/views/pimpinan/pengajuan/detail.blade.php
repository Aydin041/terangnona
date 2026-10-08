<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Pengajuan - Pimpinan - TERANG NONA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-stone-50 min-h-screen">

    @include('pimpinan._nav')

    @php
        $aman = fn ($url) => preg_match('#^https?://#i', (string) $url) === 1;
    @endphp

    <main class="max-w-4xl mx-auto px-4 py-8">
        <p class="mb-3"><a href="{{ route('pimpinan.pengajuan.index') }}" class="text-sm text-slate-500 hover:text-slate-900">← Kembali ke daftar</a></p>
        <h1 class="text-2xl font-bold text-slate-900 mb-1">Detail Pengajuan</h1>
        <p class="text-sm text-slate-500 mb-5">Hanya-lihat.</p>

        <div class="space-y-4">
            <div class="bg-white border border-stone-200 rounded-xl p-6">
                <h3 class="font-semibold text-slate-900 mb-3">Profil Inovasi</h3>
                <dl class="text-sm space-y-1.5">
                    <div class="flex flex-col sm:flex-row sm:gap-2"><dt class="text-slate-500 sm:w-40 shrink-0">Nama Inovasi</dt><dd class="text-slate-800">{{ $pengajuan->nama_inovasi }} ({{ $pengajuan->akronim }})</dd></div>
                    <div class="flex flex-col sm:flex-row sm:gap-2"><dt class="text-slate-500 sm:w-40 shrink-0">Kategori</dt><dd class="text-slate-800">{{ $pengajuan->kategori->nama }}</dd></div>
                    <div class="flex flex-col sm:flex-row sm:gap-2"><dt class="text-slate-500 sm:w-40 shrink-0">Bentuk Inovasi</dt><dd class="text-slate-800">{{ $pengajuan->bentuk_inovasi }}</dd></div>
                    <div class="flex flex-col sm:flex-row sm:gap-2"><dt class="text-slate-500 sm:w-40 shrink-0">Status Saat Ini</dt><dd class="text-slate-800">{{ $pengajuan->status }}</dd></div>
                    <div class="flex flex-col sm:flex-row sm:gap-2"><dt class="text-slate-500 sm:w-40 shrink-0">Peserta</dt><dd class="text-slate-800 break-words">{{ $pengajuan->peserta->nama }} ({{ $pengajuan->peserta->email }})</dd></div>
                </dl>
            </div>

            <div class="bg-white border border-stone-200 rounded-xl p-6">
                <h3 class="font-semibold text-slate-900 mb-3">Ketua & Anggota</h3>
                <ul class="text-sm text-slate-700 space-y-1">
                    @foreach ($pengajuan->anggotaKelompok as $anggota)
                        <li>{{ $anggota->nama }} ({{ $anggota->kontak }}) @if ($anggota->adalah_ketua) <span class="text-amber-600 font-medium">— Ketua</span> @endif</li>
                    @endforeach
                </ul>
            </div>

            <div class="bg-white border border-stone-200 rounded-xl p-6">
                <h3 class="font-semibold text-slate-900 mb-3">Dokumen Administratif</h3>
                <ul class="text-sm text-slate-700 space-y-1">
                    @forelse ($pengajuan->dokumen as $dok)
                        @continue(in_array($dok->jenis_dokumen, array_merge(array_values($lampiranUtama), array_values($lampiranTambahan)), true))
                        <li>
                            <strong class="text-slate-900">{{ $dok->jenis_dokumen }}:</strong>
                            @if ($dok->jenis_dokumen === 'video_link')
                                @if ($aman($dok->file_path))
                                    <a href="{{ $dok->file_path }}" target="_blank" rel="noopener noreferrer" class="text-sky-700 underline break-all">{{ $dok->file_path }}</a>
                                @else
                                    <span class="break-all">{{ $dok->file_path }}</span>
                                @endif
                            @else
                                {{ $dok->nama_asli }}
                                <a href="{{ asset('storage/' . $dok->file_path) }}" target="_blank" class="text-sky-700 underline">Lihat</a>
                            @endif
                        </li>
                    @empty
                        <li class="text-slate-400 italic">Belum ada dokumen.</li>
                    @endforelse
                </ul>
            </div>

            <div class="bg-white border border-stone-200 rounded-xl p-6">
                <h3 class="font-semibold text-slate-900 mb-1">Isi Proposal</h3>
                <p class="text-sm text-slate-500 mb-4">{{ $komponenList->count() }} komponen.</p>

                <div class="space-y-4">
                    @foreach ($komponenList as $komponen)
                        @php
                            $isian = $isianPerKomponen[$komponen->id] ?? null;
                            $jenisUtama = $lampiranUtama[$komponen->id] ?? null;
                            $jenisTambahan = $lampiranTambahan[$komponen->id] ?? null;
                        @endphp
                        <div class="border border-stone-200 rounded-lg p-4">
                            <p class="font-medium text-slate-900 mb-2">{{ $komponen->nama }} <span class="text-slate-400 font-normal">(Bobot {{ $komponen->bobot }}%)</span></p>

                            @if ($jenisUtama)
                                @php $dok = $dokumenPerJenis[$jenisUtama] ?? null; @endphp
                                @if ($dok)
                                    <p class="text-sm text-slate-700">Lampiran: {{ $dok->nama_asli }}
                                        <a href="{{ asset('storage/' . $dok->file_path) }}" target="_blank" class="text-sky-700 underline">Lihat</a>
                                    </p>
                                @else
                                    <p class="text-sm text-slate-400 italic">Lampiran belum diunggah.</p>
                                @endif
                            @else
                                @if ($isian && filled($isian->uraian))
                                    <p class="text-sm text-slate-800 whitespace-pre-line break-words">{{ $isian->uraian }}</p>
                                @else
                                    <p class="text-sm text-slate-400 italic">Belum diisi peserta.</p>
                                @endif

                                @if ($isian && $isian->links->isNotEmpty())
                                    <p class="text-xs font-medium text-slate-500 mt-3 mb-1">Tautan Bukti Dukung</p>
                                    <ul class="text-sm space-y-1">
                                        @foreach ($isian->links as $tautan)
                                            <li class="break-all">
                                                {{ $tautan->judul }}:
                                                @if ($aman($tautan->link))
                                                    <a href="{{ $tautan->link }}" target="_blank" rel="noopener noreferrer" class="text-sky-700 underline">{{ $tautan->link }}</a>
                                                @else
                                                    {{ $tautan->link }}
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            @endif

                            @if ($jenisTambahan)
                                @php $dokTambahan = $dokumenPerJenis[$jenisTambahan] ?? null; @endphp
                                <div class="mt-3 pt-3 border-t border-stone-200">
                                    @if ($dokTambahan)
                                        <p class="text-sm text-slate-700">Dokumen RAB: {{ $dokTambahan->nama_asli }}
                                            <a href="{{ asset('storage/' . $dokTambahan->file_path) }}" target="_blank" class="text-sky-700 underline">Lihat</a>
                                        </p>
                                    @else
                                        <p class="text-sm text-slate-400 italic">Dokumen RAB belum diunggah.</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>

    <script src="{{ asset('js/prevent-double-submit.js') }}"></script>
</body>
</html>