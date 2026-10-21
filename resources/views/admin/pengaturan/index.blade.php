@extends('layouts.admin')

@section('title', 'Pengaturan')

@section('content')
    <div class="max-w-xl">
        <h1 class="text-2xl font-bold mb-6">Pengaturan</h1>

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

        <form method="POST" action="{{ route('admin.pengaturan.update') }}" class="space-y-4">
            @csrf

            <div class="bg-white border border-line rounded-2xl p-6">
                <h2 class="font-semibold mb-1">Deadline Pengajuan</h2>
                <p class="text-sm text-slate-500 mb-4">Setelah lewat tanggal ini, Peserta tidak bisa lagi membuat pengajuan baru. Pengajuan yang sudah ada (draft/perlu perbaikan) tetap bisa diedit.</p>

                <input type="datetime-local" name="deadline_pengajuan"
                    value="{{ old('deadline_pengajuan', optional($pengaturan->deadline_pengajuan)->format('Y-m-d\TH:i')) }}"
                    class="w-full rounded-xl border border-line px-4 py-3 focus:outline-none focus:ring-2 focus:ring-brand-amber focus:border-brand-amber">
                <p class="text-xs text-slate-400 mt-1.5">Kosongkan lalu simpan untuk menghapus deadline (pengajuan dibuka lagi tanpa batas).</p>
            </div>

            <div class="bg-white border border-line rounded-2xl p-6">
                <h2 class="font-semibold mb-1">Penilaian Juri</h2>
                <p class="text-sm text-slate-500 mb-4">Nilai sebuah pengajuan baru dihitung dan masuk ranking setelah sedikitnya sejumlah ini Juri melakukan submit final.</p>

                <label for="minimal_juri_submit" class="block text-sm font-semibold mb-1.5">Minimal Juri yang Harus Submit</label>
                <input type="number" id="minimal_juri_submit" name="minimal_juri_submit" min="1" max="{{ max(1, $jumlahJuri) }}" required
                    value="{{ old('minimal_juri_submit', $pengaturan->minimal_juri_submit ?? 2) }}"
                    class="w-full rounded-xl border border-line px-4 py-3 focus:outline-none focus:ring-2 focus:ring-brand-amber focus:border-brand-amber">
                <p class="text-xs text-slate-400 mt-1.5">Saat ini ada {{ $jumlahJuri }} akun Juri. Angka tidak boleh melebihi jumlah itu.</p>
                <p class="text-xs text-amber-700 mt-2">Atur sebelum penilaian dimulai. Mengubahnya di tengah penilaian dapat mengubah hasil ranking.</p>
            </div>

            <button type="submit" class="bg-brand-amber hover:bg-brand-amber-dark text-brand-navy font-semibold rounded-xl px-8 py-3 transition-colors">
                Simpan
            </button>
        </form>
    </div>
@endsection