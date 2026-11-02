@extends('layouts.admin')

@section('title', 'Jadwal')

@section('content')
    @php
        $kelas = 'w-full rounded-xl border border-line px-4 py-3 focus:outline-none focus:ring-2 focus:ring-brand-amber focus:border-brand-amber';
    @endphp

    <div class="max-w-3xl">
        <h1 class="text-2xl font-bold mb-2">Jadwal Kegiatan</h1>
        <p class="text-sm text-slate-500 mb-6">
            Tanggal dan nama tahap yang tampil di halaman depan. Status "belum dimulai", "sedang berlangsung", dan "sudah lewat"
            berubah sendiri mengikuti tanggal. Tahun kompetisi (di judul dan teks halaman depan) mengikuti tahun
            tanggal mulai tahap pertama.
        </p>

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

        @if ($tahap->isEmpty())
            <div class="rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-sm p-4">
                Jadwal belum tersimpan di database. Jalankan <code>php artisan migrate</code> terlebih dahulu.
            </div>
        @else
            <form method="POST" action="{{ route('admin.jadwal.update') }}" class="space-y-4">
                @csrf

                @foreach ($tahap as $i => $t)
                    <div class="bg-white border border-line rounded-2xl p-6">
                        <p class="text-xs text-slate-400 mb-3">Tahap {{ $i + 1 }}</p>

                        <label for="nama-{{ $t->id }}" class="block text-sm font-semibold mb-1.5">Nama tahap</label>
                        <input type="text" id="nama-{{ $t->id }}" name="tahap[{{ $t->id }}][nama]" required maxlength="200"
                            value="{{ old('tahap.' . $t->id . '.nama', $t->nama) }}" class="{{ $kelas }}">

                        <div class="grid sm:grid-cols-2 gap-4 mt-4">
                            <div>
                                <label for="mulai-{{ $t->id }}" class="block text-sm font-semibold mb-1.5">Tanggal mulai</label>
                                <input type="date" id="mulai-{{ $t->id }}" name="tahap[{{ $t->id }}][mulai]" required
                                    value="{{ old('tahap.' . $t->id . '.mulai', $t->mulai->format('Y-m-d')) }}" class="{{ $kelas }}">
                            </div>
                            <div>
                                <label for="selesai-{{ $t->id }}" class="block text-sm font-semibold mb-1.5">Tanggal selesai</label>
                                <input type="date" id="selesai-{{ $t->id }}" name="tahap[{{ $t->id }}][selesai]" required
                                    value="{{ old('tahap.' . $t->id . '.selesai', $t->selesai->format('Y-m-d')) }}" class="{{ $kelas }}">
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="sorot-{{ $t->id }}" class="block text-sm font-semibold mb-1.5">Teks pada kartu halaman depan</label>
                            <input type="text" id="sorot-{{ $t->id }}" name="tahap[{{ $t->id }}][sorot]" maxlength="60"
                                value="{{ old('tahap.' . $t->id . '.sorot', $t->sorot) }}" class="{{ $kelas }}">
                            <p class="text-xs text-slate-400 mt-1.5">Kosongkan kalau tahap ini tidak perlu tampil sebagai kartu di bagian atas halaman depan.</p>
                        </div>

                        @if ($t->kunci === 'pendaftaran')
                            <p class="text-xs text-amber-700 mt-3">
                                Batas akhir pendaftaran yang sebenarnya mengikuti "Deadline Pengajuan" di halaman Pengaturan kalau diisi.
                            </p>
                        @endif
                    </div>
                @endforeach

                <p class="text-xs text-slate-500">
                    Pada nama tahap, tulis <code>{tahun}</code> untuk diganti otomatis dengan tahun kompetisi.
                </p>

                <button type="submit" class="bg-brand-amber hover:bg-brand-amber-dark text-brand-navy font-semibold rounded-xl px-8 py-3 transition-colors">
                    Simpan
                </button>
            </form>
        @endif
    </div>
@endsection