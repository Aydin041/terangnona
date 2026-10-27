@extends('layouts.juri')

@section('title', 'Ajukan Koreksi Nilai Proposal')

@section('content')
    @php
        $kelas = 'w-full rounded-xl border border-line px-4 py-3 focus:outline-none focus:ring-2 focus:ring-brand-amber focus:border-brand-amber';
    @endphp

    <div class="max-w-2xl">
        <p class="mb-3"><a href="{{ route('juri.penilaian.proposal', $pengajuan->uuid) }}" class="text-sm text-slate-500 hover:text-ink">← Kembali ke penilaian</a></p>
        <h1 class="text-2xl font-bold">Ajukan Koreksi Nilai Proposal</h1>
        <p class="text-slate-500 mt-1 mb-6">{{ $pengajuan->nama_inovasi }} ({{ $pengajuan->akronim }})</p>

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

        <div class="bg-white border border-line rounded-2xl p-6 mb-4">
            <h2 class="font-semibold mb-3">Nilai Anda Saat Ini (Terkunci)</h2>
            <ul class="text-sm divide-y divide-line">
                @foreach ($nilaiTerkunci as $nilai)
                    <li class="py-2 flex items-center justify-between gap-3 flex-wrap">
                        <span>{{ $nilai->komponen->nama }}: <strong class="font-bold">{{ $nilai->nilai }}</strong></span>
                        @if (in_array($nilai->komponen_id, $permintaanAktif))
                            <span class="text-xs font-semibold px-3 py-1 rounded-full bg-amber-100 text-amber-800">Menunggu Admin</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="bg-white border border-line rounded-2xl p-6">
            <h2 class="font-semibold mb-4">Ajukan Koreksi</h2>
            <form method="POST" action="{{ route('juri.koreksi.proposal.submit', $pengajuan->uuid) }}" class="space-y-4">
                @csrf

                <div>
                    <label for="komponen_id" class="block text-sm font-semibold mb-1.5">Pilih komponen yang salah</label>
                    <select id="komponen_id" name="komponen_id" required class="{{ $kelas }}">
                        <option value="">-- Pilih Komponen --</option>
                        @foreach ($nilaiTerkunci as $nilai)
                            <option value="{{ $nilai->komponen_id }}">{{ $nilai->komponen->nama }} (nilai saat ini: {{ $nilai->nilai }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="alasan" class="block text-sm font-semibold mb-1.5">Alasan koreksi</label>
                    <textarea id="alasan" name="alasan" rows="3" required class="{{ $kelas }}"></textarea>
                </div>

                <button type="submit" class="bg-brand-amber hover:bg-brand-amber-dark text-brand-navy font-semibold rounded-xl px-8 py-3 transition-colors">
                    Kirim Permintaan ke Admin
                </button>
            </form>
        </div>
    </div>
@endsection