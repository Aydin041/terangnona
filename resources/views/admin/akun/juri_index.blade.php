<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Akun Juri - Admin - TERANG NONA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-stone-50 min-h-screen">

    <nav class="bg-white border-b border-stone-200">
        <div class="max-w-2xl mx-auto px-4 py-3">
            <a href="{{ route('landing') }}">
                <img src="{{ asset('images/logo-terang-nona-transparan.png') }}" alt="TERANG NONA" class="h-10">
            </a>
        </div>
    </nav>

    <main class="max-w-2xl mx-auto px-4 py-8">
        <p class="mb-3 flex gap-3 text-sm">
            <a href="{{ route('admin.dashboard') }}" class="text-slate-500 hover:text-slate-900">← Dashboard</a>
            <a href="{{ route('admin.akun.panitia.index') }}" class="text-sky-700 hover:underline">Kelola Akun Panitia</a>
        </p>
        <h1 class="text-2xl font-bold text-slate-900 mb-5">Kelola Akun Juri</h1>

        @if (session('sukses'))
            <div class="mb-5 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm p-3">
                {{ session('sukses') }}
            </div>
        @endif

        <a href="{{ route('admin.akun.juri.create') }}"
            class="inline-block mb-5 bg-amber-500 hover:bg-amber-600 text-slate-900 font-semibold rounded-lg px-5 py-2.5 transition-colors">
            + Tambah Akun Juri
        </a>

        @if ($daftarJuri->isEmpty())
            <div class="bg-white border border-stone-200 rounded-xl p-6 text-center text-slate-500">
                Belum ada akun Juri.
            </div>
        @else
            <div class="space-y-3">
                @foreach ($daftarJuri as $item)
                    <div class="bg-white border border-stone-200 rounded-xl p-4 flex items-center justify-between flex-wrap gap-2">
                        <div>
                            <p class="font-medium text-slate-900">{{ $item->nama }}</p>
                            <p class="text-sm text-slate-500">{{ $item->email }}</p>
                        </div>
                        <a href="{{ route('admin.akun.juri.reset.form', $item->id) }}"
                            class="text-sm border border-stone-300 text-slate-700 hover:bg-stone-100 rounded-lg px-3 py-1.5">
                            Reset Password
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </main>

</body>
</html>