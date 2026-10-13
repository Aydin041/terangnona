<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Pengajuan - Panitia - TERANG NONA</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-stone-50 min-h-screen">

    <nav class="bg-white border-b border-stone-200">
        <div class="max-w-2xl mx-auto px-4 py-3">
            <a href="{{ route('panitia.dashboard') }}">
                <img src="{{ asset('images/logo-terang-nona-transparan.png') }}" alt="TERANG NONA" class="h-10">
            </a>
            <span class="text-sm text-slate-500">Login sebagai: <strong class="text-slate-700">{{ Auth::guard('panitia')->user()->nama }}</strong></span>
        </div>
    </nav>

    <main class="max-w-2xl mx-auto px-4 py-8">
        <p class="mb-3"><a href="{{ route('panitia.pengajuan.index') }}" class="text-sm text-slate-500 hover:text-slate-900">← Kembali ke daftar</a></p>
        <h1 class="text-2xl font-bold text-slate-900 mb-5">Detail Pengajuan</h1>

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
                    <div class="flex gap-2"><dt class="text-slate-500 w-40 shrink-0">Nama Inovasi</dt><dd class="text-slate-800">{{ $pengajuan->nama_inovasi }} ({{ $pengajuan->akronim }})</dd></div>
                    <div class="flex gap-2"><dt class="text-slate-500 w-40 shrink-0">Kategori</dt><dd class="text-slate-800">{{ $pengajuan->kategori->nama }}</dd></div>
                    <div class="flex gap-2"><dt class="text-slate-500 w-40 shrink-0">Bentuk Inovasi</dt><dd class="text-slate-800">{{ $pengajuan->bentuk_inovasi }}</dd></div>
                    <div class="flex gap-2"><dt class="text-slate-500 w-40 shrink-0">Status Saat Ini</dt><dd class="text-slate-800">{{ $pengajuan->status }}</dd></div>
                    <div class="flex gap-2"><dt class="text-slate-500 w-40 shrink-0">Peserta</dt><dd class="text-slate-800">{{ $pengajuan->peserta->nama }} ({{ $pengajuan->peserta->email }})</dd></div>
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

            @if (count($peringatanDuplikasi) > 0)
                <div class="bg-amber-50 border border-amber-300 rounded-xl p-4 text-sm text-amber-800">
                    <strong>⚠ Peringatan: Ditemukan kemiripan nama dengan pengajuan lain (cek manual untuk BR01):</strong>
                    <ul class="list-disc list-inside mt-1">
                        @foreach ($peringatanDuplikasi as $pengajuanId => $info)
                            <li>{{ $info }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white border border-stone-200 rounded-xl p-6">
                <h3 class="font-semibold text-slate-900 mb-3">Dokumen</h3>
                <ul class="text-sm text-slate-700 space-y-1">
                    @foreach ($pengajuan->dokumen as $dok)
                        <li>
                            <strong class="text-slate-900">{{ $dok->jenis_dokumen }}:</strong>
                            @if ($dok->jenis_dokumen === 'video_link')
                                @if (preg_match('#^https?://#i', (string) $dok->file_path) === 1)
                                    <a href="{{ $dok->file_path }}" target="_blank" rel="noopener noreferrer" class="text-sky-700 underline break-all">{{ $dok->file_path }}</a>
                                @else
                                    <span class="break-all">{{ $dok->file_path }}</span>
                                @endif
                            @else
                                {{ $dok->nama_asli }}
                                <a href="{{ asset('storage/' . $dok->file_path) }}" target="_blank" class="text-sky-700 underline">Lihat</a>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        @if ($pengajuan->status === 'menunggu_pemeriksaan')
            <div class="bg-white border border-stone-200 rounded-xl p-6 mt-4">
                <h3 class="font-semibold text-slate-900 mb-4">Aksi</h3>

                <form method="POST" action="{{ route('panitia.pengajuan.setujui', $pengajuan->id) }}" class="mb-5">
                    @csrf
                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg px-5 py-2.5 transition-colors">
                        Setujui
                    </button>
                </form>

                <form method="POST" action="{{ route('panitia.pengajuan.kembalikan', $pengajuan->id) }}">
                    @csrf
                    <label class="block text-sm font-medium text-slate-700 mb-1">Alasan pengembalian (wajib diisi kalau mau kembalikan)</label>
                    <textarea name="catatan_panitia" rows="3"
                        class="w-full rounded-lg border border-stone-300 px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500">{{ old('catatan_panitia') }}</textarea>
                    <button type="submit"
                        class="mt-3 border border-red-300 text-red-700 hover:bg-red-50 font-semibold rounded-lg px-5 py-2.5 transition-colors">
                        Kembalikan ke Peserta
                    </button>
                </form>

                <form method="POST" action="{{ route('panitia.pengajuan.tolak', $pengajuan->id) }}" class="mt-6 pt-6 border-t border-stone-200"
                    onsubmit="return confirm('Yakin mau tolak pengajuan ini? Peserta tidak bisa lanjut/edit lagi setelah ditolak.');">
                    @csrf
                    <label class="block text-sm font-medium text-slate-700 mb-1">Alasan penolakan (wajib diisi kalau mau tolak)</label>
                    <textarea name="catatan_panitia" rows="3"
                        class="w-full rounded-lg border border-stone-300 px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500">{{ old('catatan_panitia') }}</textarea>
                    <button type="submit"
                        class="mt-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg px-5 py-2.5 transition-colors">
                        Tolak Pengajuan
                    </button>
                </form>
            </div>
        @else
            <p class="mt-4 text-sm text-slate-500 italic">Pengajuan ini sudah diproses (status: {{ $pengajuan->status }}), tidak ada aksi tersedia.</p>
        @endif
    </main>

    <script src="{{ asset('js/prevent-double-submit.js') }}"></script>
</body>
</html>