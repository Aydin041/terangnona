<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pengajuan - Langkah 1 - TERANG NONA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-stone-50 min-h-screen">

    <nav class="bg-white border-b border-stone-200">
        <div class="max-w-2xl mx-auto px-4 py-3">
            <a href="{{ route('peserta.dashboard') }}">
                <img src="{{ asset('images/logo-terang-nona-transparan.png') }}" alt="TERANG NONA" class="h-10">
            </a>
            <span class="text-sm text-slate-500">Login sebagai: <strong class="text-slate-700">{{ Auth::guard('peserta')->user()->nama }}</strong></span>
        </div>
    </nav>

    <main class="max-w-2xl mx-auto px-4 py-8">
        <p class="mb-3"><a href="{{ route('peserta.dashboard') }}" class="text-sm text-slate-500 hover:text-slate-900">← Kembali ke Dashboard</a></p>
        <div class="flex items-center gap-2 mb-2">
            @for ($i = 1; $i <= 5; $i++)
                <div class="h-1.5 flex-1 rounded-full {{ $i <= 1 ? 'bg-amber-500' : 'bg-stone-200' }}"></div>
            @endfor
        </div>
        <p class="text-xs text-slate-500 mb-5">Langkah 1 dari 5</p>

        <h1 class="text-xl font-bold text-slate-900 mb-5">
            {{ $pengajuan ? 'Perbaiki Pengajuan' : 'Pengajuan Baru' }}: Profil Inovasi
        </h1>

        @if ($errors->any())
            <div class="mb-4 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm p-3">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white border border-stone-200 rounded-xl p-6">
            <form method="POST" action="{{ $pengajuan ? route('peserta.pengajuan.step1.update', $pengajuan->id) : route('peserta.pengajuan.step1.submit') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nama Inovasi</label>
                    <input type="text" name="nama_inovasi" value="{{ old('nama_inovasi', $pengajuan->nama_inovasi ?? '') }}" required
                        class="w-full rounded-lg border border-stone-300 px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Akronim</label>
                    <input type="text" name="akronim" value="{{ old('akronim', $pengajuan->akronim ?? '') }}" placeholder="contoh: PANDU GUNUNG" required
                        class="w-full rounded-lg border border-stone-300 px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi Singkat (Abstrak)</label>
                    <textarea name="deskripsi" rows="4" required
                        class="w-full rounded-lg border border-stone-300 px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500">{{ old('deskripsi', $pengajuan->deskripsi ?? '') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Jenis Inovasi</label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2">
                            <input type="radio" name="jenis_inovasi" value="digital" class="accent-amber-500" required
                                {{ old('jenis_inovasi', $pengajuan->jenis_inovasi ?? '') === 'digital' ? 'checked' : '' }}>
                            Digital
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="jenis_inovasi" value="non_digital" class="accent-amber-500" required
                                {{ old('jenis_inovasi', $pengajuan->jenis_inovasi ?? '') === 'non_digital' ? 'checked' : '' }}>
                            Non-Digital
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Kategori</label>
                    <select name="kategori_id" required
                        class="w-full rounded-lg border border-stone-300 px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($kategoriList as $kategori)
                            <option value="{{ $kategori->id }}"
                                {{ old('kategori_id', $pengajuan->kategori_id ?? '') == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Unit Kerja Pengampu Inovasi</label>
                    <select name="unit_kerja_id" required
                        class="w-full rounded-lg border border-stone-300 px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                        <option value="">-- Pilih Unit Kerja --</option>
                        @foreach ($unitKerjaList as $unit)
                            <option value="{{ $unit->id }}"
                                {{ old('unit_kerja_id', $pengajuan->unit_kerja_id ?? '') == $unit->id ? 'selected' : '' }}>
                                {{ $unit->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Tahun Implementasi/Rencana</label>
                    <input type="number" name="tahun_implementasi" value="{{ old('tahun_implementasi', $pengajuan->tahun_implementasi ?? 2026) }}" required
                        class="w-full rounded-lg border border-stone-300 px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                </div>

                <button type="submit"
                    class="w-full bg-amber-500 hover:bg-amber-600 text-slate-900 font-semibold rounded-lg py-2.5 transition-colors">
                    Lanjut ke Langkah 2
                </button>
            </form>
        </div>
    </main>

    <script src="{{ asset('js/prevent-double-submit.js') }}"></script>
</body>
</html>