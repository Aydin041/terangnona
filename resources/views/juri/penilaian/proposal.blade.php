<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nilai Proposal - Juri - TERANG NONA</title>
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
        <p class="mb-3"><a href="{{ route('juri.penilaian.daftar.proposal') }}" class="text-sm text-slate-500 hover:text-slate-900">← Kembali ke daftar</a></p>
        <h1 class="text-xl font-bold text-slate-900 mb-5">Nilai Proposal — {{ $pengajuan->nama_inovasi }} ({{ $pengajuan->akronim }})</h1>

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
            <h3 class="font-semibold text-slate-900 mb-3">Dokumen Pengajuan</h3>
            @if ($dokumenPengajuan->isEmpty())
                <p class="text-sm text-red-600">Belum ada dokumen yang diupload peserta.</p>
            @else
                <ul class="text-sm text-slate-700 space-y-1">
                    @foreach ($dokumenPengajuan as $dok)
                        <li>
                            <strong class="text-slate-900">{{ $dok->jenis_dokumen }}:</strong>
                            @if ($dok->jenis_dokumen === 'video_link')
                                <a href="{{ $dok->file_path }}" target="_blank" class="text-sky-700 underline break-all">{{ $dok->file_path }}</a>
                            @else
                                {{ $dok->nama_asli }}
                                <a href="{{ asset('storage/' . $dok->file_path) }}" target="_blank" class="text-sky-700 underline">Lihat/Download</a>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <p class="text-sm text-slate-600 mb-4"><strong class="text-slate-900">Status penilaian:</strong> {{ $submission->status }}</p>

        @if ($submission->status === 'submitted' && !$adaBarisTerbuka)
            <div class="mb-4 rounded-lg bg-sky-50 border border-sky-200 text-sky-800 text-sm p-3">
                Penilaian sudah disubmit dan terkunci.
                <a href="{{ route('juri.koreksi.proposal.form', $pengajuan->id) }}" class="underline font-medium">Ajukan Koreksi Nilai</a>
            </div>
        @endif

        @if ($submission->status === 'submitted' && $adaBarisTerbuka)
            <div class="mb-4 rounded-lg bg-amber-50 border border-amber-200 text-amber-800 text-sm p-3">
                <strong>⚠ Ada komponen yang sedang dibuka untuk diperbaiki (disetujui Admin).</strong> Isi ulang komponen yang kosong di bawah, lalu klik "Konfirmasi Perbaikan".
            </div>
        @endif

        <form method="POST" class="space-y-4">
            @csrf

            @foreach ($komponenList as $komponen)
                @php $nilaiRow = $nilaiTersimpan[$komponen->id] ?? null; @endphp
                @php $isianRow = $isianList[$komponen->id] ?? null; @endphp
                <div class="bg-white border border-stone-200 rounded-xl p-5">
                    <p class="font-medium text-slate-900 mb-3">{{ $komponen->nama }} <span class="text-slate-400 font-normal">— Bobot {{ $komponen->bobot }}%</span></p>

                    @if (array_key_exists($komponen->id, \App\Http\Controllers\Peserta\PengajuanController::KOMPONEN_LAMPIRAN))
                        @php
                            $jenisDok = \App\Http\Controllers\Peserta\PengajuanController::KOMPONEN_LAMPIRAN[$komponen->id];
                            $dokLampiran = $dokumenKeyed[$jenisDok] ?? null;
                        @endphp
                        <div class="bg-stone-50 border border-stone-200 rounded-lg p-3 mb-3 text-sm">
                            <strong class="text-slate-800">Lampiran dari Peserta:</strong>
                            @if ($dokLampiran)
                                {{ $dokLampiran->nama_asli }}
                                <a href="{{ asset('storage/' . $dokLampiran->file_path) }}" target="_blank" class="text-sky-700 underline">Lihat/Download</a>
                            @else
                                <span class="text-red-600">Belum diupload peserta.</span>
                            @endif
                        </div>
                    @else
                        <div class="bg-stone-50 border border-stone-200 rounded-lg p-3 mb-3 text-sm">
                            <strong class="text-slate-800">Uraian dari Peserta:</strong>
                            @if ($isianRow && trim((string) $isianRow->uraian) !== '')
                                <p class="whitespace-pre-wrap mt-1">{{ $isianRow->uraian }}</p>
                            @else
                                <p class="text-red-600 mt-1">Belum diisi peserta.</p>
                            @endif

                            <strong class="text-slate-800 block mt-2">Link/Tautan Bukti Dukung:</strong>
                            @if ($isianRow && $isianRow->links->isNotEmpty())
                                <ul class="list-disc list-inside">
                                    @foreach ($isianRow->links as $linkItem)
                                        <li>
                                            {{ $linkItem->judul }}:
                                            <a href="{{ $linkItem->link }}" target="_blank" class="text-sky-700 underline break-all">{{ $linkItem->link }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <span class="text-red-600">Belum diisi peserta.</span>
                            @endif

                            @php
                                $jenisTambahan = \App\Http\Controllers\Peserta\PengajuanController::KOMPONEN_LAMPIRAN_TAMBAHAN[$komponen->id] ?? null;
                                $dokTambahan = $jenisTambahan ? ($dokumenKeyed[$jenisTambahan] ?? null) : null;
                            @endphp
                            @if ($jenisTambahan)
                                <strong class="text-slate-800 block mt-2">Dokumen RAB:</strong>
                                @if ($dokTambahan)
                                    {{ $dokTambahan->nama_asli }}
                                    <a href="{{ asset('storage/' . $dokTambahan->file_path) }}" target="_blank" class="text-sky-700 underline">Lihat/Download</a>
                                @else
                                    <span class="text-red-600">Belum diupload peserta.</span>
                                @endif
                            @endif
                        </div>
                    @endif

                    <label class="block text-sm font-medium text-slate-700 mb-1">Nilai (0-100)</label>
                    <input type="number" name="nilai[{{ $komponen->id }}]" min="0" max="100"
                        value="{{ $nilaiRow->nilai ?? '' }}"
                        {{ ($nilaiRow && $nilaiRow->terkunci) ? 'disabled' : '' }}
                        class="w-32 rounded-lg border border-stone-300 px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 disabled:bg-stone-100 disabled:text-slate-400">

                    <label class="block text-sm font-medium text-slate-700 mb-1 mt-3">Saran/Masukan/Catatan</label>
                    <textarea name="komentar[{{ $komponen->id }}]" rows="2"
                        {{ ($nilaiRow && $nilaiRow->terkunci) ? 'disabled' : '' }}
                        class="w-full rounded-lg border border-stone-300 px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 disabled:bg-stone-100 disabled:text-slate-400">{{ $nilaiRow->komentar ?? '' }}</textarea>
                </div>
            @endforeach

            @if ($submission->status !== 'submitted')
                <div class="flex flex-wrap gap-3">
                    <button type="submit" formaction="{{ route('juri.penilaian.proposal.draft', $pengajuan->id) }}"
                        class="border border-stone-300 text-slate-700 hover:bg-stone-100 rounded-lg px-5 py-2.5 font-medium transition-colors">
                        Simpan Draft
                    </button>
                    <button type="submit" formaction="{{ route('juri.penilaian.proposal.submit', $pengajuan->id) }}"
                        class="bg-amber-500 hover:bg-amber-600 text-slate-900 font-semibold rounded-lg px-5 py-2.5 transition-colors">
                        Submit Penilaian
                    </button>
                </div>
            @elseif ($adaBarisTerbuka)
                <button type="submit" formaction="{{ route('juri.penilaian.proposal.perbaikan', $pengajuan->id) }}"
                    class="bg-amber-500 hover:bg-amber-600 text-slate-900 font-semibold rounded-lg px-5 py-2.5 transition-colors">
                    Konfirmasi Perbaikan
                </button>
            @endif
        </form>
    </main>

    <script src="{{ asset('js/prevent-double-submit.js') }}"></script>
</body>
</html>