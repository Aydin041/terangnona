@extends('layouts.peserta')

@section('title', 'Pengajuan - Langkah 1')

@section('content')
    @php
        $kelas = 'w-full rounded-xl border border-line px-4 py-3 focus:outline-none focus:ring-2 focus:ring-brand-amber focus:border-brand-amber';
    @endphp

    <div class="max-w-3xl mx-auto">
        <p class="mb-4"><a href="{{ route('peserta.dashboard') }}" class="text-sm text-slate-500 hover:text-ink">← Kembali ke Dashboard</a></p>

        @include('peserta.pengajuan._stepper', ['langkah' => 1])

        <h1 class="text-2xl font-bold mb-5">{{ $pengajuan ? 'Perbaiki Pengajuan' : 'Pengajuan Baru' }}: Profil Inovasi</h1>

        @if ($errors->any())
            <div class="mb-5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm p-3">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white border border-line rounded-2xl p-6 sm:p-8">
            <form method="POST" action="{{ $pengajuan ? route('peserta.pengajuan.step1.update', $pengajuan->uuid) : route('peserta.pengajuan.step1.submit') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="nama_inovasi" class="block text-sm font-semibold mb-1.5">Nama Inovasi</label>
                    <input type="text" id="nama_inovasi" name="nama_inovasi" value="{{ old('nama_inovasi', $pengajuan->nama_inovasi ?? '') }}" required class="{{ $kelas }}">
                </div>

                <div>
                    <label for="akronim" class="block text-sm font-semibold mb-1.5">Akronim</label>
                    <input type="text" id="akronim" name="akronim" value="{{ old('akronim', $pengajuan->akronim ?? '') }}" placeholder="contoh: PANDU GUNUNG" required class="{{ $kelas }}">
                </div>

                <div>
                    <label for="deskripsi" class="block text-sm font-semibold mb-1.5">Deskripsi Singkat (Abstrak)</label>
                    <textarea id="deskripsi" name="deskripsi" rows="4" required class="{{ $kelas }}">{{ old('deskripsi', $pengajuan->deskripsi ?? '') }}</textarea>
                </div>

                <div>
                    <span class="block text-sm font-semibold mb-1.5">Jenis Inovasi</span>
                    <div class="flex gap-6">
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

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label for="kategori_id" class="block text-sm font-semibold mb-1.5">Kategori</label>
                        <select id="kategori_id" name="kategori_id" required class="{{ $kelas }}">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($kategoriList as $kategori)
                                <option value="{{ $kategori->id }}" {{ old('kategori_id', $pengajuan->kategori_id ?? '') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="unit_kerja_id" class="block text-sm font-semibold mb-1.5">Unit Kerja Pengampu Inovasi</label>
                        <select id="unit_kerja_id" name="unit_kerja_id" required class="{{ $kelas }}">
                            <option value="">-- Pilih Unit Kerja --</option>
                            @foreach ($unitKerjaList as $unit)
                                <option value="{{ $unit->id }}" {{ old('unit_kerja_id', $pengajuan->unit_kerja_id ?? '') == $unit->id ? 'selected' : '' }}>
                                    {{ $unit->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label for="tahun_implementasi" class="block text-sm font-semibold mb-1.5">Tahun Implementasi/Rencana</label>
                    <input type="number" id="tahun_implementasi" name="tahun_implementasi" value="{{ old('tahun_implementasi', $pengajuan->tahun_implementasi ?? 2026) }}" required class="{{ $kelas }}">
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit" class="bg-brand-amber hover:bg-brand-amber-dark text-brand-navy font-semibold rounded-xl px-8 py-3 transition-colors">
                        Lanjut ke Langkah 2
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection