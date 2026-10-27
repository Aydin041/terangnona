@extends('layouts.juri')

@section('title', 'Nilai Presentasi')

@section('content')
    @php
        $aspekBobot = ['teknik_penyajian' => 20, 'substansi_materi' => 70, 'komitmen_pimpinan' => 10];
        $kelasNilai = 'w-32 rounded-xl border border-line px-4 py-3 focus:outline-none focus:ring-2 focus:ring-brand-amber focus:border-brand-amber disabled:bg-surface disabled:text-slate-400';
        $kelasCatatan = 'w-full rounded-xl border border-line px-4 py-3 focus:outline-none focus:ring-2 focus:ring-brand-amber focus:border-brand-amber disabled:bg-surface disabled:text-slate-400';
    @endphp

    <div class="max-w-3xl mx-auto">
        <p class="mb-3"><a href="{{ route('juri.penilaian.daftar.presentasi') }}" class="text-sm text-slate-500 hover:text-ink">← Kembali ke daftar</a></p>
        <h1 class="text-2xl font-bold mb-1">Nilai Presentasi & Wawancara</h1>
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
                <a href="{{ route('juri.koreksi.presentasi.form', $pengajuan->uuid) }}" class="underline font-semibold">Ajukan Koreksi Nilai</a>
            </div>
        @endif

        @if ($submission->status === 'submitted' && $adaBarisTerbuka)
            <div class="mb-5 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-sm p-4">
                <strong class="font-semibold">⚠ Ada aspek yang sedang dibuka untuk diperbaiki (disetujui Admin).</strong> Isi ulang aspek yang kosong di bawah, lalu klik "Konfirmasi Perbaikan".
            </div>
        @endif

        <form method="POST" class="space-y-4">
            @csrf

            @foreach ($aspekList as $kode => $label)
                @php $nilaiRow = $nilaiTersimpan[$kode] ?? null; @endphp
                <div class="bg-white border border-line rounded-2xl p-6">
                    <p class="font-semibold mb-3">{{ $label }} <span class="text-slate-400 font-normal text-sm">(Bobot {{ $aspekBobot[$kode] ?? '-' }}%)</span></p>

                    <label class="block text-sm font-semibold mb-1.5">Nilai (0-100)</label>
                    <input type="number" name="nilai[{{ $kode }}]" min="0" max="100"
                        value="{{ $nilaiRow->nilai ?? '' }}"
                        {{ ($nilaiRow && $nilaiRow->terkunci) ? 'disabled' : '' }}
                        class="{{ $kelasNilai }}">

                    <label class="block text-sm font-semibold mb-1.5 mt-4">Catatan</label>
                    <textarea name="catatan[{{ $kode }}]" rows="2"
                        {{ ($nilaiRow && $nilaiRow->terkunci) ? 'disabled' : '' }}
                        class="{{ $kelasCatatan }}">{{ $nilaiRow->catatan ?? '' }}</textarea>
                </div>
            @endforeach

            @if ($submission->status !== 'submitted')
                <div class="flex flex-wrap gap-3">
                    <button type="submit" formaction="{{ route('juri.penilaian.presentasi.draft', $pengajuan->uuid) }}"
                        class="border border-line bg-white hover:border-brand-amber font-semibold rounded-xl px-6 py-3 transition-colors">
                        Simpan Draft
                    </button>
                    <button type="submit" formaction="{{ route('juri.penilaian.presentasi.submit', $pengajuan->uuid) }}"
                        class="bg-brand-amber hover:bg-brand-amber-dark text-brand-navy font-semibold rounded-xl px-8 py-3 transition-colors">
                        Submit Penilaian
                    </button>
                </div>
            @elseif ($adaBarisTerbuka)
                <button type="submit" formaction="{{ route('juri.penilaian.presentasi.perbaikan', $pengajuan->uuid) }}"
                    class="bg-brand-amber hover:bg-brand-amber-dark text-brand-navy font-semibold rounded-xl px-8 py-3 transition-colors">
                    Konfirmasi Perbaikan
                </button>
            @endif
        </form>
    </div>
@endsection