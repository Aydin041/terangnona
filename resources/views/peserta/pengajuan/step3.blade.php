@extends('layouts.peserta')

@section('title', 'Pengajuan - Langkah 3')

@section('content')
    @php
        $kelas = 'w-full rounded-xl border border-line px-4 py-3 focus:outline-none focus:ring-2 focus:ring-brand-amber focus:border-brand-amber';
    @endphp

    <div class="max-w-3xl mx-auto">
        <p class="mb-4"><a href="{{ route('peserta.pengajuan.step2', $pengajuan->uuid) }}" class="text-sm text-slate-500 hover:text-ink">← Kembali ke Langkah 2</a></p>

        @include('peserta.pengajuan._stepper', ['langkah' => 3])

        <h1 class="text-2xl font-bold">Data Ketua & Anggota</h1>
        <p class="text-slate-500 mt-1 mb-5">{{ $pengajuan->nama_inovasi }} ({{ $pengajuan->akronim }})</p>

        @if ($errors->any())
            <div class="mb-5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm p-3">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('peserta.pengajuan.step3.submit', $pengajuan->uuid) }}" class="space-y-4">
            @csrf

            <div class="bg-white border border-line rounded-2xl p-6">
                <h2 class="font-semibold mb-3">Ketua <span class="font-normal text-slate-400">(terisi otomatis dari akun Anda)</span></h2>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold mb-1.5">Nama Ketua</label>
                        <input type="text" value="{{ $peserta->nama }}" disabled class="w-full rounded-xl border border-line bg-surface px-4 py-3 text-slate-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1.5">Kontak Ketua</label>
                        <input type="text" value="{{ $peserta->kontak }}" disabled class="w-full rounded-xl border border-line bg-surface px-4 py-3 text-slate-500">
                    </div>
                </div>
            </div>

            <div class="bg-white border border-line rounded-2xl p-6">
                <h2 class="font-semibold mb-3">Anggota Tambahan <span class="font-normal text-slate-400">(opsional)</span></h2>

                <div id="anggota-container" class="space-y-3">
                    @foreach ($anggotaLain as $anggota)
                        <div class="baris-anggota border border-line rounded-xl p-4 grid sm:grid-cols-2 gap-3 items-end">
                            <div>
                                <label class="block text-sm font-semibold mb-1.5">Nama Anggota</label>
                                <input type="text" name="anggota_nama[]" value="{{ $anggota->nama }}" class="{{ $kelas }}">
                            </div>
                            <div class="flex gap-2 items-end">
                                <div class="flex-1 min-w-0">
                                    <label class="block text-sm font-semibold mb-1.5">Kontak Anggota</label>
                                    <input type="text" name="anggota_kontak[]" value="{{ $anggota->kontak }}" class="{{ $kelas }}">
                                </div>
                                <button type="button" onclick="hapusAnggota(this)" class="text-red-600 hover:text-red-800 text-sm border border-red-200 rounded-xl px-4 h-[50px]">Hapus</button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <button type="button" onclick="tambahAnggota()" class="mt-4 text-sm font-medium border border-line hover:border-brand-amber rounded-xl px-4 py-2 transition-colors">
                    + Tambah Anggota
                </button>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="bg-brand-amber hover:bg-brand-amber-dark text-brand-navy font-semibold rounded-xl px-8 py-3 transition-colors">
                    Lanjut ke Langkah 4
                </button>
            </div>
        </form>
    </div>

    <script>
        function tambahAnggota() {
            const container = document.getElementById('anggota-container');
            const div = document.createElement('div');
            div.className = 'baris-anggota border border-line rounded-xl p-4 grid sm:grid-cols-2 gap-3 items-end';
            div.innerHTML = `
                <div>
                    <label class="block text-sm font-semibold mb-1.5">Nama Anggota</label>
                    <input type="text" name="anggota_nama[]" class="w-full rounded-xl border border-line px-4 py-3 focus:outline-none focus:ring-2 focus:ring-brand-amber focus:border-brand-amber">
                </div>
                <div class="flex gap-2 items-end">
                    <div class="flex-1 min-w-0">
                        <label class="block text-sm font-semibold mb-1.5">Kontak Anggota</label>
                        <input type="text" name="anggota_kontak[]" class="w-full rounded-xl border border-line px-4 py-3 focus:outline-none focus:ring-2 focus:ring-brand-amber focus:border-brand-amber">
                    </div>
                    <button type="button" onclick="hapusAnggota(this)" class="text-red-600 hover:text-red-800 text-sm border border-red-200 rounded-xl px-4 h-[50px]">Hapus</button>
                </div>
            `;
            container.appendChild(div);
        }

        function hapusAnggota(tombol) {
            tombol.closest('.baris-anggota').remove();
        }
    </script>
@endsection