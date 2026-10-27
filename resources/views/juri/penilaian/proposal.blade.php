@extends('layouts.juri')

@section('title', 'Nilai Proposal')

@section('content')
    @php
        $kelasNilai = 'w-32 rounded-xl border border-line px-4 py-3 focus:outline-none focus:ring-2 focus:ring-brand-amber focus:border-brand-amber disabled:bg-surface disabled:text-slate-400';
        $kelasCatatan = 'w-full rounded-xl border border-line px-4 py-3 focus:outline-none focus:ring-2 focus:ring-brand-amber focus:border-brand-amber disabled:bg-surface disabled:text-slate-400';
    @endphp

    <div class="max-w-3xl mx-auto">
        <p class="mb-3"><a href="{{ route('juri.penilaian.daftar.proposal') }}" class="text-sm text-slate-500 hover:text-ink">← Kembali ke daftar</a></p>
        <h1 class="text-2xl font-bold mb-1">Nilai Proposal</h1>
        <p class="text-slate-500 mb-6">{{ $pengajuan->nama_inovasi }} ({{ $pengajuan->akronim }})</p>

        @if ($errors->any())
            <div class="mb-5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm p-3">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('sukses'))
            <div class="mb-5 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm p-3">
                {{ session('sukses') }}
            </div>
        @endif

        <div class="bg-white border border-line rounded-2xl p-6 mb-5">
            <h2 class="font-semibold mb-3">Dokumen Pengajuan</h2>
            @if ($dokumenPengajuan->isEmpty())
                <p class="text-sm text-red-600">Belum ada dokumen yang diisi peserta.</p>
            @else
                <ul class="text-sm space-y-1.5">
                    @foreach ($dokumenPengajuan as $dok)
                        <li>
                            <strong class="font-semibold">{{ $dok->jenis_dokumen }}:</strong>
                            <a href="{{ $dok->tautan }}" target="_blank" rel="noopener noreferrer" class="text-brand-blue underline break-all">{{ $dok->label }}</a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <p class="text-sm mb-4">
            <strong class="font-semibold">Status penilaian:</strong>
            <span class="ml-1 text-xs font-semibold px-3 py-1 rounded-full {{ $submission->status === 'submitted' ? 'bg-green-100 text-green-800' : 'bg-amber-100 text-amber-800' }}">
                {{ $submission->status === 'submitted' ? 'Sudah submit' : 'Draft' }}
            </span>
        </p>

        @if (!empty($koreksiDitolak))
            <div class="mb-5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm p-4">
                <strong class="font-semibold">Permintaan koreksi ditolak Admin:</strong>
                {{ implode(', ', $koreksiDitolak) }}.
                Nilai pada bagian tersebut tetap terkunci seperti sebelumnya.
            </div>
        @endif

        @if ($submission->status === 'submitted' && !$adaBarisTerbuka)
            <div class="mb-5 rounded-xl bg-sky-50 border border-sky-200 text-sky-800 text-sm p-4">
                Penilaian sudah disubmit dan terkunci.
                <a href="{{ route('juri.koreksi.proposal.form', $pengajuan->uuid) }}" class="underline font-semibold">Ajukan Koreksi Nilai</a>
            </div>
        @endif

        @if ($submission->status === 'submitted' && $adaBarisTerbuka)
            <div class="mb-5 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-sm p-4">
                <strong class="font-semibold">⚠ Ada komponen yang sedang dibuka untuk diperbaiki (disetujui Admin).</strong> Isi ulang komponen yang kosong di bawah, lalu klik "Konfirmasi Perbaikan".
            </div>
        @endif

        <form method="POST" class="space-y-4">
            @csrf

            @foreach ($komponenList as $komponen)
                @php
                    $nilaiRow = $nilaiTersimpan[$komponen->id] ?? null;
                    $isianRow = $isianList[$komponen->id] ?? null;
                @endphp
                <div class="bg-white border border-line rounded-2xl p-6">
                    <p class="font-semibold mb-3">{{ $komponen->nama }} <span class="text-slate-400 font-normal text-sm">— Bobot {{ $komponen->bobot }}%</span></p>

                    @if (array_key_exists($komponen->id, \App\Http\Controllers\Peserta\PengajuanController::KOMPONEN_LAMPIRAN))
                        @php
                            $jenisDok = \App\Http\Controllers\Peserta\PengajuanController::KOMPONEN_LAMPIRAN[$komponen->id];
                            $dokLampiran = $dokumenKeyed[$jenisDok] ?? null;
                        @endphp
                        <div class="bg-surface border border-line rounded-xl p-4 mb-4 text-sm">
                            <strong class="font-semibold">Lampiran dari Peserta:</strong>
                            @if ($dokLampiran)
                                <a href="{{ $dokLampiran->tautan }}" target="_blank" rel="noopener noreferrer" class="text-brand-blue underline break-all">{{ $dokLampiran->label }}</a>
                            @else
                                <span class="text-red-600">Belum diisi peserta.</span>
                            @endif
                        </div>
                    @else
                        <div class="bg-surface border border-line rounded-xl p-4 mb-4 text-sm">
                            <strong class="font-semibold">Uraian dari Peserta:</strong>
                            @if ($isianRow && trim((string) $isianRow->uraian) !== '')
                                <p class="whitespace-pre-wrap mt-1 break-words">{{ $isianRow->uraian }}</p>
                            @else
                                <p class="text-red-600 mt-1">Belum diisi peserta.</p>
                            @endif

                            <strong class="font-semibold block mt-3">Link/Tautan Bukti Dukung:</strong>
                            @if ($isianRow && $isianRow->links->isNotEmpty())
                                <ul class="list-disc list-inside mt-1">
                                    @foreach ($isianRow->links as $linkItem)
                                        <li class="break-all">
                                            {{ $linkItem->judul }}:
                                            @if (preg_match('#^https?://#i', (string) $linkItem->link) === 1)
                                                <a href="{{ $linkItem->link }}" target="_blank" rel="noopener noreferrer" class="text-brand-blue underline">{{ $linkItem->link }}</a>
                                            @else
                                                <span>{{ $linkItem->link }}</span>
                                            @endif
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
                                <strong class="font-semibold block mt-3">Dokumen RAB:</strong>
                                @if ($dokTambahan)
                                    <a href="{{ $dokTambahan->tautan }}" target="_blank" rel="noopener noreferrer" class="text-brand-blue underline break-all">{{ $dokTambahan->label }}</a>
                                @else
                                    <span class="text-red-600">Belum diisi peserta.</span>
                                @endif
                            @endif
                        </div>
                    @endif

                    <label class="block text-sm font-semibold mb-1.5">Nilai (0-100)</label>
                    <input type="number" name="nilai[{{ $komponen->id }}]" min="0" max="100"
                        value="{{ $nilaiRow->nilai ?? '' }}"
                        {{ ($nilaiRow && $nilaiRow->terkunci) ? 'disabled' : '' }}
                        class="{{ $kelasNilai }}">

                    <label class="block text-sm font-semibold mb-1.5 mt-4">Saran/Masukan/Catatan</label>
                    <textarea name="komentar[{{ $komponen->id }}]" rows="2"
                        {{ ($nilaiRow && $nilaiRow->terkunci) ? 'disabled' : '' }}
                        class="{{ $kelasCatatan }}">{{ $nilaiRow->komentar ?? '' }}</textarea>
                </div>
            @endforeach

            @if ($submission->status !== 'submitted')
                <div class="flex flex-wrap gap-3">
                    <button type="submit" formaction="{{ route('juri.penilaian.proposal.draft', $pengajuan->uuid) }}"
                        class="border border-line bg-white hover:border-brand-amber font-semibold rounded-xl px-6 py-3 transition-colors">
                        Simpan Draft
                    </button>
                    <button type="submit" formaction="{{ route('juri.penilaian.proposal.submit', $pengajuan->uuid) }}"
                        class="bg-brand-amber hover:bg-brand-amber-dark text-brand-navy font-semibold rounded-xl px-8 py-3 transition-colors">
                        Submit Penilaian
                    </button>
                </div>
            @elseif ($adaBarisTerbuka)
                <button type="submit" formaction="{{ route('juri.penilaian.proposal.perbaikan', $pengajuan->uuid) }}"
                    class="bg-brand-amber hover:bg-brand-amber-dark text-brand-navy font-semibold rounded-xl px-8 py-3 transition-colors">
                    Konfirmasi Perbaikan
                </button>
            @endif
        </form>
    </div>
@endsection