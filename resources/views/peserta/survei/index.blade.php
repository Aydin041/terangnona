@extends('layouts.peserta')

@section('title', 'Survei Kepuasan')

@section('content')
    @php
        $tahunSurvei = \App\Models\TahapJadwal::tahun();
        $format = fn ($waktu) => $waktu->copy()->locale('id')->translatedFormat('j F Y, H.i') . ' WIB';
    @endphp

    <div class="max-w-3xl mx-auto">
        <p class="mb-3"><a href="{{ route('peserta.dashboard') }}" class="text-sm text-slate-500 hover:text-ink">← Kembali ke Dashboard</a></p>

        @if (session('sukses'))
            <div class="mb-5 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm p-3">
                {{ session('sukses') }}
            </div>
        @endif

        @if (! $layak)
            <h1 class="text-2xl font-bold mb-4">Survei Kepuasan</h1>
            <div class="bg-white border border-line rounded-2xl p-8 text-center">
                <h2 class="font-semibold">Survei hanya untuk peserta yang sudah mengajukan</h2>
                <p class="text-sm text-slate-500 mt-1">Kirim sedikitnya satu pengajuan terlebih dahulu untuk dapat mengisi survei.</p>
            </div>
        @elseif ($sudahMengisi)
            <h1 class="text-2xl font-bold mb-4">Survei Kepuasan</h1>
            <div class="bg-white border border-line rounded-2xl p-8 text-center">
                <h2 class="font-semibold">Terima kasih, survei sudah diisi</h2>
                <p class="text-sm text-slate-500 mt-1">Masukan Anda sangat membantu penyelenggaraan TERANG NONA berikutnya.</p>
            </div>
        @elseif ($status === 'tidak_aktif' || $status === 'belum_dibuka')
            <h1 class="text-2xl font-bold mb-4">Survei Kepuasan</h1>
            <div class="bg-white border border-line rounded-2xl p-8 text-center">
                <h2 class="font-semibold">Survei belum dibuka</h2>
                @if ($dibuka && $ditutup)
                    <p class="text-sm text-slate-500 mt-1">Survei dibuka pada {{ $format($dibuka) }} sampai {{ $format($ditutup) }}.</p>
                @endif
            </div>
        @elseif ($status === 'ditutup')
            <h1 class="text-2xl font-bold mb-4">Survei Kepuasan</h1>
            <div class="bg-white border border-line rounded-2xl p-8 text-center">
                <h2 class="font-semibold">Survei sudah ditutup</h2>
                <p class="text-sm text-slate-500 mt-1">Terima kasih atas partisipasi Anda.</p>
            </div>
        @else
            <style>
                .skala { display: flex; align-items: center; gap: .6rem; flex-wrap: wrap; }
                .skala span { position: relative; display: inline-block; }
                .skala input { position: absolute; opacity: 0; width: 1px; height: 1px; }
                .skala label.bulat {
                    display: inline-flex; align-items: center; justify-content: center;
                    width: 44px; height: 44px; border-radius: 9999px; border: 1px solid #e1e6f0;
                    background: #fff; font-weight: 600; cursor: pointer;
                }
                .skala input:checked + label.bulat { background: #f5a31a; border-color: #f5a31a; color: #0a1431; }
                .skala input:focus-visible + label.bulat { outline: 2px solid #1f6fa8; outline-offset: 2px; }
                .kartu-tanya { border-left: 4px solid #f5a31a; }
            </style>

            <h1 class="text-2xl font-bold">Survei Kepuasan Penyelenggaraan</h1>
            <p class="text-slate-500 mt-1">Berikan penilaian Anda atas penyelenggaraan kompetisi TERANG NONA {{ $tahunSurvei }}</p>
            <p class="text-xs text-slate-400 mt-1 mb-5">Jawaban Anda tidak ditampilkan bersama nama Anda.</p>

            @if ($errors->any())
                <div class="mb-5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm p-3">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('peserta.survei.kirim') }}" class="space-y-4">
                @csrf

                <div class="kartu-tanya bg-white border border-line rounded-2xl p-6">
                    <p class="font-semibold">Seberapa baik penyelenggaraan kompetisi TERANG NONA {{ $tahunSurvei }}? <span class="text-red-600">*</span></p>
                    <div class="skala mt-4">
                        <span class="text-sm text-slate-500">Kurang Baik</span>
                        @foreach ([1, 2, 3, 4, 5] as $n)
                            <span>
                                <input type="radio" id="nilai-{{ $n }}" name="nilai" value="{{ $n }}" required @checked((string) old('nilai') === (string) $n)>
                                <label class="bulat" for="nilai-{{ $n }}">{{ $n }}</label>
                            </span>
                        @endforeach
                        <span class="text-sm text-slate-500">Baik Sekali</span>
                    </div>
                </div>

                <div class="kartu-tanya bg-white border border-line rounded-2xl p-6">
                    <p class="font-semibold">Aspek apa saja yang perlu ditingkatkan pada penyelenggaraan kompetisi TERANG NONA? <span class="text-red-600">*</span></p>
                    <div class="mt-3 space-y-2">
                        @foreach ($aspekList as $kunci => $label)
                            <label class="flex items-center gap-3 text-sm cursor-pointer">
                                <input type="checkbox" name="aspek[]" value="{{ $kunci }}" style="accent-color:#f5a31a;width:1.1rem;height:1.1rem"
                                    @checked(in_array($kunci, old('aspek', []), true))>
                                <span>{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="kartu-tanya bg-white border border-line rounded-2xl p-6">
                    <label for="saran" class="block font-semibold">Tuliskan saran dan masukan Anda untuk pengembangan penyelenggaraan kompetisi TERANG NONA di masa mendatang. <span class="text-red-600">*</span></label>
                    <textarea id="saran" name="saran" rows="4" required maxlength="2000"
                        class="w-full mt-3 rounded-xl border border-line px-4 py-3 focus:outline-none focus:ring-2 focus:ring-brand-amber focus:border-brand-amber">{{ old('saran') }}</textarea>
                </div>

                <button type="submit" class="bg-brand-amber hover:bg-brand-amber-dark text-brand-navy font-semibold rounded-xl px-8 py-3 transition-colors">
                    Kirim
                </button>
            </form>
        @endif
    </div>
@endsection