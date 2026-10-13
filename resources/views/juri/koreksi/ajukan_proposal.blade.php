<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ajukan Koreksi Nilai - Juri - TERANG NONA</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-stone-50 min-h-screen">

    <nav class="bg-white border-b border-stone-200">
        <div class="max-w-2xl mx-auto px-4 py-3 flex items-center justify-between flex-wrap gap-2">
            <a href="{{ route('juri.dashboard') }}">
                <img src="{{ asset('images/logo-terang-nona-transparan.png') }}" alt="TERANG NONA" class="h-10">
            </a>
            <span class="text-sm text-slate-600">{{ Auth::guard('juri')->user()->nama }} <span class="text-slate-400">({{ Auth::guard('juri')->user()->email }})</span></span>
        </div>
    </nav>

    <main class="max-w-2xl mx-auto px-4 py-8">
        <p class="mb-3"><a href="{{ route('juri.penilaian.proposal', $pengajuan->id) }}" class="text-sm text-slate-500 hover:text-slate-900">← Kembali ke penilaian</a></p>
        <h1 class="text-xl font-bold text-slate-900">Ajukan Koreksi Nilai Proposal</h1>
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

        @if (session('sukses'))
            <div class="mb-4 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm p-3">
                {{ session('sukses') }}
            </div>
        @endif

        <div class="bg-white border border-stone-200 rounded-xl p-6 mb-6">
            <h3 class="font-semibold text-slate-900 mb-3">Nilai Anda Saat Ini (Terkunci)</h3>
            <ul class="text-sm text-slate-700 space-y-1.5">
                @foreach ($nilaiTerkunci as $nilai)
                    <li>
                        {{ $nilai->komponen->nama }}: <strong class="text-slate-900">{{ $nilai->nilai }}</strong>
                        @if (in_array($nilai->komponen_id, $permintaanAktif))
                            <span class="text-amber-600"> — [Permintaan koreksi sedang menunggu Admin]</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="bg-white border border-stone-200 rounded-xl p-6">
            <h3 class="font-semibold text-slate-900 mb-4">Ajukan Koreksi</h3>
            <form method="POST" action="{{ route('juri.koreksi.proposal.submit', $pengajuan->id) }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Pilih komponen yang salah</label>
                    <select name="komponen_id" required
                        class="w-full rounded-lg border border-stone-300 px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                        <option value="">-- Pilih Komponen --</option>
                        @foreach ($nilaiTerkunci as $nilai)
                            <option value="{{ $nilai->komponen_id }}">
                                {{ $nilai->komponen->nama }} (nilai saat ini: {{ $nilai->nilai }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Alasan koreksi</label>
                    <textarea name="alasan" rows="3" required
                        class="w-full rounded-lg border border-stone-300 px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500"></textarea>
                </div>

                <button type="submit"
                    class="bg-amber-500 hover:bg-amber-600 text-slate-900 font-semibold rounded-lg px-5 py-2.5 transition-colors">
                    Kirim Permintaan ke Admin
                </button>
            </form>
        </div>
    </main>

    <script src="{{ asset('js/prevent-double-submit.js') }}"></script>
</body>
</html>