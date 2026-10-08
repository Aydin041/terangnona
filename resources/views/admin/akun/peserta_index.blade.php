<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Akun Peserta - Admin - TERANG NONA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-stone-50 min-h-screen">

    <nav class="bg-white border-b border-stone-200">
        <div class="max-w-2xl mx-auto px-4 py-3">
            <a href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('images/logo-terang-nona-transparan.png') }}" alt="TERANG NONA" class="h-10">
            </a>
            <span class="text-sm text-slate-500">Login sebagai: <strong class="text-slate-700">{{ Auth::guard('admin')->user()->nama }}</strong></span>
        </div>
    </nav>

    <main class="max-w-2xl mx-auto px-4 py-8">
        <p class="mb-3 flex flex-wrap gap-x-3 gap-y-1 text-sm">
            <a href="{{ route('admin.dashboard') }}" class="text-slate-500 hover:text-slate-900">← Dashboard</a>
            <a href="{{ route('admin.akun.panitia.index') }}" class="text-sky-700 hover:underline">Kelola Akun Panitia</a>
            <a href="{{ route('admin.akun.juri.index') }}" class="text-sky-700 hover:underline">Kelola Akun Juri</a>
            <a href="{{ route('admin.akun.pimpinan.index') }}" class="text-sky-700 hover:underline">Kelola Akun Pimpinan</a>
        </p>
        <h1 class="text-2xl font-bold text-slate-900 mb-1">Kelola Akun Peserta</h1>
        <p class="text-sm text-slate-500 mb-5">Peserta daftar sendiri lewat halaman registrasi — di sini Admin hanya bisa menghapus akun yang belum punya pengajuan (misal akun spam/salah daftar).</p>

        @if ($errors->any())
            <div class="mb-5 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm p-3">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('sukses'))
            <div class="mb-5 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm p-3">
                {{ session('sukses') }}
            </div>
        @endif

        @if ($daftarPeserta->isEmpty())
            <div class="bg-white border border-stone-200 rounded-xl p-6 text-center text-slate-500">
                Belum ada akun Peserta.
            </div>
        @else
            <div class="space-y-3">
                @foreach ($daftarPeserta as $item)
                    <div class="bg-white border border-stone-200 rounded-xl p-4 flex items-center justify-between flex-wrap gap-2">
                        <div>
                            <p class="font-medium text-slate-900">{{ $item->nama }}</p>
                            <p class="text-sm text-slate-500">{{ $item->email }} @if($item->kontak) | {{ $item->kontak }} @endif</p>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('admin.akun.peserta.reset.form', $item->id) }}"
                                class="text-sm border border-stone-300 text-slate-700 hover:bg-stone-100 rounded-lg px-3 py-1.5">
                                Reset Password
                            </a>
                            <form method="POST" action="{{ route('admin.akun.peserta.hapus', $item->id) }}"
                                onsubmit="return confirm('Yakin mau hapus akun Peserta {{ $item->nama }}? Tidak bisa dikembalikan.');">
                                @csrf
                                <button type="submit" class="text-sm border border-red-300 text-red-700 hover:bg-red-50 rounded-lg px-3 py-1.5">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </main>

</body>
</html>