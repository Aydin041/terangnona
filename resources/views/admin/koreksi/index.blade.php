<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Permintaan Koreksi Nilai - Admin - TERANG NONA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
</head>
<body class="bg-stone-50 min-h-screen">

    <nav class="bg-white border-b border-stone-200">
        <div class="max-w-2xl mx-auto px-4 py-3 flex items-center justify-between flex-wrap gap-2">
            <a href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('images/logo-terang-nona-transparan.png') }}" alt="TERANG NONA" class="h-10">
            </a>
            <span class="text-sm text-slate-500">Login sebagai: <strong class="text-slate-700">{{ Auth::guard('admin')->user()->nama }}</strong></span>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="text-sm text-slate-600 hover:text-slate-900 border border-stone-300 rounded-lg px-3 py-1.5">Logout</button>
            </form>
        </div>
    </nav>

    <main class="max-w-2xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold text-slate-900 mb-1">Dashboard Admin</h1>
        <p class="mb-5 flex gap-3 text-sm">
            <a href="{{ route('admin.akun.panitia.index') }}" class="text-sky-700 hover:underline">Kelola Akun Panitia</a>
            <a href="{{ route('admin.akun.juri.index') }}" class="text-sky-700 hover:underline">Kelola Akun Juri</a>
            <a href="{{ route('admin.akun.peserta.index') }}" class="text-sky-700 hover:underline">Kelola Akun Peserta</a>
            <a href="{{ route('admin.pengaturan.form') }}" class="text-sky-700 hover:underline">Pengaturan Deadline</a>
            <a href="{{ route('admin.laporan.index') }}" class="text-sky-700 hover:underline">Laporan Nilai</a>
        </p>

        <div class="grid sm:grid-cols-2 gap-4 mb-8">
            <div class="bg-white border border-stone-200 rounded-xl p-4">
                <h2 class="font-semibold text-slate-900 mb-3 text-sm">Pengajuan per Status</h2>
                <canvas id="chartStatus" height="200"></canvas>
            </div>
            <div class="bg-white border border-stone-200 rounded-xl p-4">
                <h2 class="font-semibold text-slate-900 mb-3 text-sm">Kategori Inovasi</h2>
                <canvas id="chartKategori" height="200"></canvas>
            </div>
        </div>

        <h2 class="text-xl font-bold text-slate-900 mb-1">Permintaan Buka-Kunci Nilai</h2>

        @if (session('sukses'))
            <div class="mb-5 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm p-3">
                {{ session('sukses') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-5 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm p-3">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if ($daftarPermintaan->isEmpty())
            <div class="bg-white border border-stone-200 rounded-xl p-6 text-center text-slate-500">
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
                        ][$item->status_persetujuan] ?? 'bg-stone-100 text-stone-700';
                    @endphp
                    <div class="bg-white border border-stone-200 rounded-xl p-4">
                        <div class="flex items-start justify-between gap-3 flex-wrap">
                            <p class="text-sm text-slate-800">
                                <strong class="text-slate-900">{{ $item->juri->nama }}</strong> → {{ $item->pengajuan->nama_inovasi }} ({{ $item->pengajuan->akronim }})
                            </p>
                            <span class="text-xs font-medium px-2.5 py-1 rounded-full {{ $badge }}">{{ $item->status_persetujuan }}</span>
                        </div>
                        <p class="text-sm text-slate-500 mt-1">Tahap: {{ $item->tahap }}</p>
                        @if ($item->tahap === 'proposal')
                            <p class="text-sm text-slate-500">Komponen: {{ $item->komponen->nama ?? '-' }}</p>
                        @else
                            <p class="text-sm text-slate-500">Aspek: {{ $item->aspek }}</p>
                        @endif
                        <p class="text-sm text-slate-700 mt-2"><strong class="text-slate-900">Alasan:</strong> {{ $item->alasan }}</p>

                        @if ($item->status_persetujuan === 'menunggu')
                            <div class="flex gap-2 mt-3">
                                <form method="POST" action="{{ route('admin.koreksi.setujui', $item->id) }}">
                                    @csrf
                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg px-4 py-2 transition-colors">Setujui</button>
                                </form>
                                <form method="POST" action="{{ route('admin.koreksi.tolak', $item->id) }}">
                                    @csrf
                                    <button type="submit" class="border border-red-300 text-red-700 hover:bg-red-50 text-sm font-semibold rounded-lg px-4 py-2 transition-colors">Tolak</button>
                                </form>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </main>

    <script src="{{ asset('js/prevent-double-submit.js') }}"></script>
    <script>
        new Chart(document.getElementById('chartStatus'), {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($jumlahPerStatus->toArray())) !!},
                datasets: [{
                    label: 'Jumlah Pengajuan',
                    data: {!! json_encode(array_values($jumlahPerStatus->toArray())) !!},
                    backgroundColor: '#f59e0b',
                }],
            },
            options: {
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0 } },
                    x: { ticks: { autoSkip: false, font: { size: 11 } } },
                },
            },
        });

        new Chart(document.getElementById('chartKategori'), {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($jumlahPerKategori->toArray())) !!},
                datasets: [{
                    label: 'Jumlah Pengajuan',
                    data: {!! json_encode(array_values($jumlahPerKategori->toArray())) !!},
                    backgroundColor: '#0284c7',
                }],
            },
            options: {
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { precision: 0 } } },
            },
        });
    </script>
</body>
</html>