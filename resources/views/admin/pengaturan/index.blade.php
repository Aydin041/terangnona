<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pengaturan Deadline - Admin - TERANG NONA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-stone-50 min-h-screen">

    <nav class="bg-white border-b border-stone-200">
        <div class="max-w-md mx-auto px-4 py-3">
            <a href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('images/logo-terang-nona-transparan.png') }}" alt="TERANG NONA" class="h-10">
            </a>
            <span class="text-sm text-slate-500">Login sebagai: <strong class="text-slate-700">{{ Auth::guard('admin')->user()->nama }}</strong></span>
        </div>
    </nav>

    <main class="max-w-md mx-auto px-4 py-8">
        <p class="mb-3"><a href="{{ route('admin.dashboard') }}" class="text-sm text-slate-500 hover:text-slate-900">← Dashboard</a></p>
        <h1 class="text-xl font-bold text-slate-900 mb-2">Pengaturan Deadline Pengajuan</h1>
        <p class="text-sm text-slate-500 mb-5">Setelah lewat tanggal ini, Peserta tidak bisa lagi membuat pengajuan baru. Pengajuan yang sudah ada (draft/perlu perbaikan) tetap bisa diedit.</p>

        @if ($errors->any())
            <div class="mb-4 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm p-3">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('sukses'))
            <div class="mb-4 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm p-3">
                {{ session('sukses') }}
            </div>
        @endif

        <div class="bg-white border border-stone-200 rounded-xl p-6">
            <form method="POST" action="{{ route('admin.pengaturan.update') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Deadline Pengajuan</label>
                    <input type="datetime-local" name="deadline_pengajuan"
                        value="{{ old('deadline_pengajuan', optional($pengaturan->deadline_pengajuan)->format('Y-m-d\TH:i')) }}"
                        class="w-full rounded-lg border border-stone-300 px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                    <p class="text-xs text-slate-400 mt-1">Kosongkan lalu simpan untuk menghapus deadline (pengajuan dibuka lagi tanpa batas).</p>
                </div>

                <button type="submit"
                    class="w-full bg-amber-500 hover:bg-amber-600 text-slate-900 font-semibold rounded-lg py-2.5 transition-colors">
                    Simpan
                </button>
            </form>
        </div>
    </main>

    <script src="{{ asset('js/prevent-double-submit.js') }}"></script>
</body>
</html>