@extends('layouts.panitia')

@section('title', 'Detail Pengajuan')

@section('content')
    <p class="mb-3"><a href="{{ route('panitia.pengajuan.index') }}" class="text-sm text-slate-500 hover:text-ink">← Kembali ke daftar</a></p>
    <h1 class="text-2xl font-bold mb-6">Detail Pengajuan</h1>

    @if ($errors->any())
        <div class="mb-5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm p-3">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="space-y-4">
        <div class="bg-white border border-line rounded-2xl p-6">
            <h2 class="font-semibold mb-4">Profil Inovasi</h2>
            <dl class="text-sm divide-y divide-line">
                <div class="flex flex-col sm:flex-row sm:gap-4 py-2"><dt class="text-slate-500 sm:w-44 shrink-0">Nama Inovasi</dt><dd>{{ $pengajuan->nama_inovasi }} ({{ $pengajuan->akronim }})</dd></div>
                <div class="flex flex-col sm:flex-row sm:gap-4 py-2"><dt class="text-slate-500 sm:w-44 shrink-0">Kategori</dt><dd>{{ $pengajuan->kategori->nama }}</dd></div>
                <div class="flex flex-col sm:flex-row sm:gap-4 py-2"><dt class="text-slate-500 sm:w-44 shrink-0">Bentuk Inovasi</dt><dd>{{ $pengajuan->bentuk_inovasi }}</dd></div>
                <div class="flex flex-col sm:flex-row sm:gap-4 py-2"><dt class="text-slate-500 sm:w-44 shrink-0">Status Saat Ini</dt><dd><x-badge-status :status="$pengajuan->status" /></dd></div>
                <div class="flex flex-col sm:flex-row sm:gap-4 py-2"><dt class="text-slate-500 sm:w-44 shrink-0">Peserta</dt><dd class="break-words">{{ $pengajuan->peserta->nama }} ({{ $pengajuan->peserta->email }})</dd></div>
            </dl>
        </div>

        <div class="bg-white border border-line rounded-2xl p-6">
            <h2 class="font-semibold mb-3">Ketua & Anggota</h2>
            <ul class="text-sm space-y-1">
                @foreach ($pengajuan->anggotaKelompok as $anggota)
                    <li>{{ $anggota->nama }} ({{ $anggota->kontak }}) @if ($anggota->adalah_ketua) <span class="text-brand-amber-dark font-semibold">— Ketua</span> @endif</li>
                @endforeach
            </ul>

            @if (count($peringatanDuplikasi) > 0)
                <div class="mt-4 rounded-xl bg-amber-50 border border-amber-300 p-4 text-sm text-amber-800">
                    <strong class="font-semibold">⚠ Peringatan: ditemukan kemiripan nama dengan pengajuan lain (cek manual untuk BR01):</strong>
                    <ul class="list-disc list-inside mt-1">
                        @foreach ($peringatanDuplikasi as $pengajuanId => $info)
                            <li>{{ $info }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <div class="bg-white border border-line rounded-2xl p-6">
            <h2 class="font-semibold mb-3">Dokumen</h2>
            <ul class="text-sm space-y-1.5">
                @forelse ($pengajuan->dokumen as $dok)
                    <li>
                        <strong class="font-semibold">{{ $dok->jenis_dokumen }}:</strong>
                        <a href="{{ $dok->tautan }}" target="_blank" rel="noopener noreferrer" class="text-brand-blue underline break-all">{{ $dok->label }}</a>
                    </li>
                @empty
                    <li class="text-slate-400 italic">Belum ada dokumen.</li>
                @endforelse
            </ul>
        </div>

        @if ($pengajuan->status === 'menunggu_pemeriksaan')
            <div class="bg-white border border-line rounded-2xl p-6">
                <h2 class="font-semibold mb-4">Aksi</h2>

                <form method="POST" action="{{ route('panitia.pengajuan.setujui', $pengajuan->uuid) }}" class="mb-6">
                    @csrf
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl px-6 py-2.5 transition-colors">
                        Setujui
                    </button>
                </form>

                <form method="POST" action="{{ route('panitia.pengajuan.kembalikan', $pengajuan->uuid) }}">
                    @csrf
                    <label class="block text-sm font-semibold mb-1.5">Alasan pengembalian <span class="font-normal text-slate-400">(wajib diisi kalau mau kembalikan)</span></label>
                    <textarea name="catatan_panitia" rows="3"
                        class="w-full rounded-xl border border-line px-4 py-3 focus:outline-none focus:ring-2 focus:ring-brand-amber focus:border-brand-amber">{{ old('catatan_panitia') }}</textarea>
                    <button type="submit" class="mt-3 border border-red-300 text-red-700 hover:bg-red-50 font-semibold rounded-xl px-6 py-2.5 transition-colors">
                        Kembalikan ke Peserta
                    </button>
                </form>

                <form method="POST" action="{{ route('panitia.pengajuan.tolak', $pengajuan->uuid) }}" class="mt-6 pt-6 border-t border-line"
                    onsubmit="return confirm('Yakin mau tolak pengajuan ini? Peserta tidak bisa lanjut/edit lagi setelah ditolak.');">
                    @csrf
                    <label class="block text-sm font-semibold mb-1.5">Alasan penolakan <span class="font-normal text-slate-400">(wajib diisi kalau mau tolak)</span></label>
                    <textarea name="catatan_panitia" rows="3"
                        class="w-full rounded-xl border border-line px-4 py-3 focus:outline-none focus:ring-2 focus:ring-brand-amber focus:border-brand-amber">{{ old('catatan_panitia') }}</textarea>
                    <button type="submit" class="mt-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl px-6 py-2.5 transition-colors">
                        Tolak Pengajuan
                    </button>
                </form>
            </div>
        @else
            <p class="text-sm text-slate-500 italic">Pengajuan ini sudah diproses (status: {{ $pengajuan->status }}), tidak ada aksi tersedia.</p>
        @endif
    </div>
@endsection