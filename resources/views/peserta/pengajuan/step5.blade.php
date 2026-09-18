<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pengajuan - Langkah 5 - TERANG NONA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-stone-50 min-h-screen">

    <nav class="bg-white border-b border-stone-200">
        <div class="max-w-2xl mx-auto px-4 py-3">
            <a href="{{ route('landing') }}">
                <img src="{{ asset('images/logo-terang-nona-transparan.png') }}" alt="TERANG NONA" class="h-10">
            </a>
        </div>
    </nav>

    <main class="max-w-2xl mx-auto px-4 py-8">
        <div class="flex items-center gap-2 mb-2">
            @for ($i = 1; $i <= 5; $i++)
                <div class="h-1.5 flex-1 rounded-full bg-amber-500"></div>
            @endfor
        </div>
        <p class="text-xs text-slate-500 mb-5">Langkah 5 dari 5</p>

        <h1 class="text-xl font-bold text-slate-900 mb-5">Review & Submit</h1>

        @if ($errors->any())
            <div class="mb-4 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm p-3">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="space-y-4">
            <div class="bg-white border border-stone-200 rounded-xl p-6">
                <h3 class="font-semibold text-slate-900 mb-3">Profil Inovasi</h3>
                <dl class="text-sm space-y-1.5">
                    <div class="flex gap-2"><dt class="text-slate-500 w-44 shrink-0">Nama Inovasi</dt><dd class="text-slate-800">{{ $pengajuan->nama_inovasi }} ({{ $pengajuan->akronim }})</dd></div>
                    <div class="flex gap-2"><dt class="text-slate-500 w-44 shrink-0">Kategori</dt><dd class="text-slate-800">{{ $pengajuan->kategori->nama }}</dd></div>
                    <div class="flex gap-2"><dt class="text-slate-500 w-44 shrink-0">Bentuk Inovasi</dt><dd class="text-slate-800">{{ $pengajuan->bentuk_inovasi }}</dd></div>
                    <div class="flex gap-2"><dt class="text-slate-500 w-44 shrink-0">Tahun Implementasi</dt><dd class="text-slate-800">{{ $pengajuan->tahun_implementasi }}</dd></div>
                </dl>
            </div>

            <div class="bg-white border border-stone-200 rounded-xl p-6">
                <h3 class="font-semibold text-slate-900 mb-3">Ketua & Anggota</h3>
                <ul class="text-sm text-slate-700 space-y-1">
                    @foreach ($anggotaKelompok as $anggota)
                        <li>{{ $anggota->nama }} ({{ $anggota->kontak }}) @if ($anggota->adalah_ketua) <span class="text-amber-600 font-medium">— Ketua</span> @endif</li>
                    @endforeach
                </ul>
            </div>

            <div class="bg-white border border-stone-200 rounded-xl p-6">
                <h3 class="font-semibold text-slate-900 mb-3">Dokumen</h3>
                @if (count($dokumenBelumLengkap) > 0)
                    <div class="rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm p-3">
                        <p class="font-medium mb-1">Dokumen berikut belum lengkap:</p>
                        <ul class="list-disc list-inside">
                            @foreach ($dokumenBelumLengkap as $jenis)
                                <li>{{ $jenis }}</li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <ul class="text-sm text-slate-700 space-y-1">
                        @foreach ($dokumenTersimpan as $jenis => $dok)
                            <li>
                                {{ $jenis }}:
                                @if ($jenis === 'video_link')
                                    <a href="{{ $dok->file_path }}" target="_blank" class="text-sky-700 underline break-all">{{ $dok->file_path }}</a>
                                @else
                                    {{ $dok->nama_asli }}
                                    <a href="{{ asset('storage/' . $dok->file_path) }}" target="_blank" class="text-sky-700 underline">Lihat</a>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <div class="bg-white border border-stone-200 rounded-xl p-6">
                <h3 class="font-semibold text-slate-900 mb-3">Isian Proposal</h3>
                @if (count($isianBelumLengkap) > 0)
                    <div class="rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm p-3">
                        <p class="font-medium mb-1">Komponen berikut belum diisi:</p>
                        <ul class="list-disc list-inside">
                            @foreach ($isianBelumLengkap as $namaKomponen)
                                <li>{{ $namaKomponen }}</li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <p class="text-sm text-green-700">Semua komponen sudah diisi.</p>
                @endif
            </div>
        </div>

        <div class="mt-6">
            @if (count($dokumenBelumLengkap) > 0 || count($isianBelumLengkap) > 0)
                <a href="{{ route('peserta.pengajuan.step4', $pengajuan->id) }}"
                    class="inline-block bg-slate-900 hover:bg-slate-800 text-white font-semibold rounded-lg px-5 py-2.5 transition-colors">
                    ← Kembali ke Langkah 4 untuk Melengkapi
                </a>
            @else
                <form method="POST" action="{{ route('peserta.pengajuan.step5.submit', $pengajuan->id) }}">
                    @csrf
                    <button type="submit"
                        class="w-full bg-amber-500 hover:bg-amber-600 text-slate-900 font-semibold rounded-lg py-2.5 transition-colors">
                        Submit Pengajuan
                    </button>
                </form>
            @endif
        </div>
    </main>

    <script src="{{ asset('js/prevent-double-submit.js') }}"></script>
</body>
</html>