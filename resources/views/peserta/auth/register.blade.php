<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrasi Peserta - TERANG NONA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-stone-50 min-h-screen flex items-center justify-center px-4 py-10">

    <div class="w-full max-w-sm">
        <div class="text-center mb-6">
            <a href="{{ route('landing') }}" class="inline-block">
                <img src="{{ asset('images/logo-terang-nona-transparan.png') }}" alt="TERANG NONA" class="h-20 mx-auto">
            </a>
            <p class="text-slate-500 text-sm mt-1">Daftar sebagai peserta</p>
        </div>

        <div class="bg-white border border-stone-200 border-t-4 border-t-amber-500 rounded-xl p-6 shadow-sm">
            <h1 class="text-xl font-bold text-slate-900 mb-5">Registrasi Peserta</h1>

            @if ($errors->any())
                <div class="mb-4 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm p-3">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('peserta.register.submit') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ old('nama') }}" required
                        class="w-full rounded-lg border border-stone-300 px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full rounded-lg border border-stone-300 px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nomor Kontak/WA</label>
                    <input type="text" name="kontak" value="{{ old('kontak') }}" required
                        class="w-full rounded-lg border border-stone-300 px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Password (minimal 8 karakter)</label>
                    <input type="password" name="password" required
                        class="w-full rounded-lg border border-stone-300 px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required
                        class="w-full rounded-lg border border-stone-300 px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                </div>

                <button type="submit"
                    class="w-full bg-amber-500 hover:bg-amber-600 text-slate-900 font-semibold rounded-lg py-2.5 transition-colors">
                    Daftar
                </button>
            </form>
        </div>

        <p class="text-center text-sm text-slate-600 mt-5">
            Sudah punya akun?
            <a href="{{ route('peserta.login') }}" class="text-slate-900 font-medium underline decoration-amber-500 decoration-2 underline-offset-2">Login di sini</a>
        </p>
    </div>

    <script src="{{ asset('js/prevent-double-submit.js') }}"></script>
</body>
</html>