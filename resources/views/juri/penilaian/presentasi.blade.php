<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nilai Presentasi - Juri - TERANG NONA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-stone-50 min-h-screen">

    <nav class="bg-white border-b border-stone-200">
        <div class="max-w-2xl mx-auto px-4 py-3 flex items-center justify-between flex-wrap gap-2">
            <a href="{{ route('juri.dashboard') }}">
                <img src="{{ asset('images/logo-terang-nona-transparan.png') }}" alt="TERANG NONA" class="h-10">
            </a>
            <span class="text-sm text-slate-600">{{ $juri->nama }} <span class="text-slate-400">({{ $juri->email }})</span></span>
        </div>
    </nav>

    <main class="max-w-2xl mx-auto px-4 py-8">
        <p class="mb-3"><a href="{{ route('juri.penilaian.daftar.presentasi') }}" class="text-sm text-slate-500 hover:text-slate-900">← Kembali ke daftar</a></p>
        <h1 class="text-xl font-bold text-slate-900 mb-5">Nilai Presentasi & Wawancara — {{ $pengajuan->nama_inovasi }} ({{ $pengajuan->akronim }})</h1>

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

        <p class="text-sm text-slate-600 mb-2"><strong class="text-slate-900">Status penilaian:</strong> {{ $submission->status }}</p>

        <div class="mb-4 bg-white border border-stone-200 rounded-xl p-4 text-sm">
            <strong class="text-slate-900">Link Zoom/Meet Presentasi:</strong>
            @if ($pengajuan->link_presentasi)
                <a href="{{ $pengajuan->link_presentasi }}" target="_blank" class="text-sky-700 underline break-all">{{ $pengajuan->link_presentasi }}</a>
            @else
                <span class="text-red-600">Belum diisi Panitia.</span>
            @endif
        </div>

        @if ($submission->status === 'submitted' && !$adaBarisTerbuka)
            <div class="mb-4 rounded-lg bg-sky-50 border border-sky-200 text-sky-800 text-sm p-3">
                Penilaian sudah disubmit dan terkunci.
                <a href="{{ route('juri.koreksi.presentasi.form', $pengajuan->id) }}" class="underline font-medium">Ajukan Koreksi Nilai</a>
            </div>
        @endif

        @if ($submission->status === 'submitted' && $adaBarisTerbuka)
            <div class="mb-4 rounded-lg bg-amber-50 border border-amber-200 text-amber-800 text-sm p-3">
                <strong>⚠ Ada aspek yang sedang dibuka untuk diperbaiki (disetujui Admin).</strong> Isi ulang aspek yang kosong di bawah, lalu klik "Konfirmasi Perbaikan".
            </div>
        @endif

        <form method="POST" class="space-y-4">
            @csrf

            @foreach ($aspekList as $kode => $label)
                @php $nilaiRow = $nilaiTersimpan[$kode] ?? null; @endphp
                <div class="bg-white border border-stone-200 rounded-xl p-5">
                    <p class="font-medium text-slate-900 mb-3">{{ $label }}</p>

                    <label class="block text-sm font-medium text-slate-700 mb-1">Nilai (0-100)</label>
                    <input type="number" name="nilai[{{ $kode }}]" min="0" max="100"
                        value="{{ $nilaiRow->nilai ?? '' }}"
                        {{ ($nilaiRow && $nilaiRow->terkunci) ? 'disabled' : '' }}
                        class="w-32 rounded-lg border border-stone-300 px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 disabled:bg-stone-100 disabled:text-slate-400">

                    <label class="block text-sm font-medium text-slate-700 mb-1 mt-3">Catatan</label>
                    <textarea name="catatan[{{ $kode }}]" rows="2"
                        {{ ($nilaiRow && $nilaiRow->terkunci) ? 'disabled' : '' }}
                        class="w-full rounded-lg border border-stone-300 px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 disabled:bg-stone-100 disabled:text-slate-400">{{ $nilaiRow->catatan ?? '' }}</textarea>
                </div>
            @endforeach

            @if ($submission->status !== 'submitted')
                <div class="flex flex-wrap gap-3">
                    <button type="submit" formaction="{{ route('juri.penilaian.presentasi.draft', $pengajuan->id) }}"
                        class="border border-stone-300 text-slate-700 hover:bg-stone-100 rounded-lg px-5 py-2.5 font-medium transition-colors">
                        Simpan Draft
                    </button>
                    <button type="submit" formaction="{{ route('juri.penilaian.presentasi.submit', $pengajuan->id) }}"
                        class="bg-amber-500 hover:bg-amber-600 text-slate-900 font-semibold rounded-lg px-5 py-2.5 transition-colors">
                        Submit Penilaian
                    </button>
                </div>
            @elseif ($adaBarisTerbuka)
                <button type="submit" formaction="{{ route('juri.penilaian.presentasi.perbaikan', $pengajuan->id) }}"
                    class="bg-amber-500 hover:bg-amber-600 text-slate-900 font-semibold rounded-lg px-5 py-2.5 transition-colors">
                    Konfirmasi Perbaikan
                </button>
            @endif
        </form>
    </main>

    <script src="{{ asset('js/prevent-double-submit.js') }}"></script>
</body>
</html>