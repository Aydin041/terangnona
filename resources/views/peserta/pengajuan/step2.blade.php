<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pengajuan - Langkah 2 - TERANG NONA</title>
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
        <p class="mb-3"><a href="{{ route('peserta.pengajuan.step1.edit', $pengajuan->id) }}" class="text-sm text-slate-500 hover:text-slate-900">← Kembali ke Langkah 1</a></p>
        <div class="flex items-center gap-2 mb-2">
            @for ($i = 1; $i <= 5; $i++)
                <div class="h-1.5 flex-1 rounded-full {{ $i <= 2 ? 'bg-amber-500' : 'bg-stone-200' }}"></div>
            @endfor
        </div>
        <p class="text-xs text-slate-500 mb-5">Langkah 2 dari 5</p>

        <h1 class="text-xl font-bold text-slate-900">Bentuk Inovasi</h1>
        <p class="text-slate-500 text-sm mb-5">{{ $pengajuan->nama_inovasi }} ({{ $pengajuan->akronim }})</p>

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
            <form method="POST" action="{{ route('peserta.pengajuan.step2.submit', $pengajuan->id) }}" class="space-y-3">
                @csrf

                <label class="flex items-start gap-3 border border-stone-200 rounded-lg p-4 cursor-pointer hover:border-amber-400">
                    <input type="radio" name="bentuk_inovasi" value="eksisting" required class="mt-1 accent-amber-500"
                        {{ old('bentuk_inovasi', $pengajuan->bentuk_inovasi) === 'eksisting' ? 'checked' : '' }}>
                    <span class="text-slate-800">Inovasi Eksisting <span class="block text-sm text-slate-500">(sudah berjalan minimal 1 tahun)</span></span>
                </label>

                <label class="flex items-start gap-3 border border-stone-200 rounded-lg p-4 cursor-pointer hover:border-amber-400">
                    <input type="radio" name="bentuk_inovasi" value="pengembangan" required class="mt-1 accent-amber-500"
                        {{ old('bentuk_inovasi', $pengajuan->bentuk_inovasi) === 'pengembangan' ? 'checked' : '' }}>
                    <span class="text-slate-800">Pengembangan Inovasi</span>
                </label>

                <label class="flex items-start gap-3 border border-stone-200 rounded-lg p-4 cursor-pointer hover:border-amber-400">
                    <input type="radio" name="bentuk_inovasi" value="rancangan" required class="mt-1 accent-amber-500"
                        {{ old('bentuk_inovasi', $pengajuan->bentuk_inovasi) === 'rancangan' ? 'checked' : '' }}>
                    <span class="text-slate-800">Rancangan Inovasi <span class="block text-sm text-slate-500">(baru)</span></span>
                </label>

                <button type="submit"
                    class="w-full bg-amber-500 hover:bg-amber-600 text-slate-900 font-semibold rounded-lg py-2.5 transition-colors mt-2">
                    Lanjut ke Langkah 3
                </button>
            </form>
        </div>
    </main>

    <script src="{{ asset('js/prevent-double-submit.js') }}"></script>
</body>
</html>