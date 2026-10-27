@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Dashboard Admin</h1>

    @php
        $labelStatus = [
            'draft' => 'Draft',
            'menunggu_pemeriksaan' => 'Menunggu Pemeriksaan',
            'disetujui' => 'Disetujui',
            'perlu_perbaikan' => 'Perlu Perbaikan',
            'ditolak' => 'Ditolak',
        ];
    @endphp

    <div class="grid sm:grid-cols-2 gap-4 mb-10">
        <div class="bg-white border border-line rounded-2xl p-6">
            <h2 class="font-semibold mb-3">Pengajuan per Status</h2>
            <ul class="divide-y divide-line text-sm">
                @foreach ($labelStatus as $kunci => $label)
                    <li class="flex items-center justify-between py-2">
                        <span class="text-slate-600">{{ $label }}</span>
                        <strong class="font-bold">{{ $jumlahPerStatus[$kunci] ?? 0 }}</strong>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="bg-white border border-line rounded-2xl p-6">
            <h2 class="font-semibold mb-3">Bentuk Inovasi</h2>
            <ul class="divide-y divide-line text-sm">
                @forelse ($jumlahPerKategori as $nama => $jumlah)
                    <li class="flex items-center justify-between py-2">
                        <span class="text-slate-600">{{ ucfirst($nama) }}</span>
                        <strong class="font-bold">{{ $jumlah }}</strong>
                    </li>
                @empty
                    <li class="py-2 text-slate-400 italic">Belum ada data.</li>
                @endforelse
            </ul>
        </div>
    </div>

    <h2 class="text-xl font-bold mb-1">Permintaan Buka-Kunci Nilai</h2>
    <p class="text-slate-500 text-sm mb-4">Juri mengajukan koreksi untuk nilai yang sudah terkunci.</p>

    @if (session('sukses'))
        <div class="mb-5 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm p-3">
            {{ session('sukses') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm p-3">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($daftarPermintaan->isEmpty())
        <div class="bg-white border border-line rounded-2xl p-8 text-center text-slate-500">
            Belum ada permintaan koreksi.
        </div>
    @else
        <div class="space-y-3">
            @foreach ($daftarPermintaan as $item)
                @php
                    $badge = [
                        'menunggu' => 'bg-amber-100 text-amber-800',
                        'disetujui' => 'bg-green-100 text-green-800',
                        'ditolak' => 'bg-red-100 text-red-800',
                    ][$item->status_persetujuan] ?? 'bg-slate-100 text-slate-700';
                @endphp
                <div class="bg-white border border-line rounded-2xl p-5">
                    <div class="flex items-start justify-between gap-3 flex-wrap">
                        <p class="text-sm">
                            <strong class="font-semibold">{{ $item->juri->nama }}</strong>
                            → {{ $item->pengajuan->nama_inovasi }} ({{ $item->pengajuan->akronim }})
                        </p>
                        <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $badge }}">{{ $item->status_persetujuan }}</span>
                    </div>
                    <p class="text-sm text-slate-500 mt-1">Tahap: {{ $item->tahap }}</p>
                    @if ($item->tahap === 'proposal')
                        <p class="text-sm text-slate-500">Komponen: {{ $item->komponen->nama ?? '-' }}</p>
                    @else
                        <p class="text-sm text-slate-500">Aspek: {{ \App\Http\Controllers\Juri\PenilaianController::ASPEK_PRESENTASI[$item->aspek] ?? $item->aspek }}</p>
                    @endif
                    <p class="text-sm mt-2"><strong class="font-semibold">Alasan:</strong> {{ $item->alasan }}</p>

                    @if ($item->status_persetujuan === 'menunggu')
                        <div class="flex gap-2 mt-4">
                            <form method="POST" action="{{ route('admin.koreksi.setujui', $item->uuid) }}">
                                @csrf
                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-xl px-5 py-2 transition-colors">Setujui</button>
                            </form>
                            <form method="POST" action="{{ route('admin.koreksi.tolak', $item->uuid) }}">
                                @csrf
                                <button type="submit" class="border border-red-300 text-red-700 hover:bg-red-50 text-sm font-semibold rounded-xl px-5 py-2 transition-colors">Tolak</button>
                            </form>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
@endsection