<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pengajuan - Langkah 3 - TERANG NONA</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
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
        <p class="mb-3"><a href="{{ route('peserta.pengajuan.step2', $pengajuan->id) }}" class="text-sm text-slate-500 hover:text-slate-900">← Kembali ke Langkah 2</a></p>
        <div class="flex items-center gap-2 mb-2">
            @for ($i = 1; $i <= 5; $i++)
                <div class="h-1.5 flex-1 rounded-full {{ $i <= 3 ? 'bg-amber-500' : 'bg-stone-200' }}"></div>
            @endfor
        </div>
        <p class="text-xs text-slate-500 mb-5">Langkah 3 dari 5</p>

        <h1 class="text-xl font-bold text-slate-900">Data Ketua & Anggota</h1>
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
            <form method="POST" action="{{ route('peserta.pengajuan.step3.submit', $pengajuan->id) }}" class="space-y-5">
                @csrf

                <div>
                    <h3 class="font-semibold text-slate-900 mb-2">Ketua (terisi otomatis dari akun Anda)</h3>
                    <div class="grid sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Nama Ketua</label>
                            <input type="text" value="{{ $peserta->nama }}" disabled
                                class="w-full rounded-lg border border-stone-200 bg-stone-100 px-3 py-2 text-slate-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Kontak Ketua</label>
                            <input type="text" value="{{ $peserta->kontak }}" disabled
                                class="w-full rounded-lg border border-stone-200 bg-stone-100 px-3 py-2 text-slate-500">
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="font-semibold text-slate-900 mb-2">Anggota Tambahan (opsional)</h3>
                    <div id="anggota-container" class="space-y-3">
                        @foreach ($anggotaLain as $anggota)
                            <div class="baris-anggota border border-stone-200 rounded-lg p-3 grid sm:grid-cols-2 gap-3 items-end">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Nama Anggota</label>
                                    <input type="text" name="anggota_nama[]" value="{{ $anggota->nama }}"
                                        class="w-full rounded-lg border border-stone-300 px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                                </div>
                                <div class="flex gap-2">
                                    <div class="flex-1">
                                        <label class="block text-sm font-medium text-slate-700 mb-1">Kontak Anggota</label>
                                        <input type="text" name="anggota_kontak[]" value="{{ $anggota->kontak }}"
                                            class="w-full rounded-lg border border-stone-300 px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                                    </div>
                                    <button type="button" onclick="hapusAnggota(this)"
                                        class="text-red-600 hover:text-red-800 text-sm border border-red-200 rounded-lg px-3 h-[42px]">Hapus</button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <button type="button" onclick="tambahAnggota()"
                        class="mt-3 text-sm text-slate-700 border border-stone-300 rounded-lg px-4 py-2 hover:bg-stone-100">
                        + Tambah Anggota
                    </button>
                </div>

                <button type="submit"
                    class="w-full bg-amber-500 hover:bg-amber-600 text-slate-900 font-semibold rounded-lg py-2.5 transition-colors">
                    Lanjut ke Langkah 4
                </button>
            </form>
        </div>
    </main>

    <script>
        function tambahAnggota() {
            const container = document.getElementById('anggota-container');
            const div = document.createElement('div');
            div.className = 'baris-anggota border border-stone-200 rounded-lg p-3 grid sm:grid-cols-2 gap-3 items-end';
            div.innerHTML = `
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nama Anggota</label>
                    <input type="text" name="anggota_nama[]" class="w-full rounded-lg border border-stone-300 px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                </div>
                <div class="flex gap-2">
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Kontak Anggota</label>
                        <input type="text" name="anggota_kontak[]" class="w-full rounded-lg border border-stone-300 px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                    </div>
                    <button type="button" onclick="hapusAnggota(this)" class="text-red-600 hover:text-red-800 text-sm border border-red-200 rounded-lg px-3 h-[42px]">Hapus</button>
                </div>
            `;
            container.appendChild(div);
        }

        function hapusAnggota(tombol) {
            const baris = tombol.closest('.baris-anggota');
            baris.remove();
        }
    </script>
    <script src="{{ asset('js/prevent-double-submit.js') }}"></script>
</body>
</html>