<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Pimpinan - TERANG NONA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-stone-50 min-h-screen flex items-center justify-center px-4 py-8">

    <div class="w-full max-w-sm">
        <div class="text-center mb-6">
            <a href="{{ route('landing') }}">
                <img src="{{ asset('images/logo-terang-nona-transparan.png') }}" alt="TERANG NONA" class="h-16 mx-auto">
            </a>
        </div>

        <div class="bg-white border border-stone-200 rounded-xl p-6">
            <h1 class="text-xl font-bold text-slate-900 mb-1">Login Pimpinan</h1>
            <p class="text-sm text-slate-500 mb-5">Akses khusus untuk melihat perkembangan dan hasil kompetisi.</p>

            @if ($errors->any())
                <div class="mb-4 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm p-3">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('pimpinan.login.submit') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full rounded-lg border border-stone-300 px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                    <div class="flex gap-2">
                        <input type="password" id="password" name="password" required
                            class="w-full min-w-0 rounded-lg border border-stone-300 px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                        <button type="button" id="toggle-password"
                            class="shrink-0 text-sm text-slate-600 border border-stone-300 rounded-lg px-3 hover:bg-stone-100">
                            Tampilkan
                        </button>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-amber-500 hover:bg-amber-600 text-slate-900 font-semibold rounded-lg py-2.5 transition-colors">
                    Masuk
                </button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('toggle-password').addEventListener('click', function () {
            const input = document.getElementById('password');
            const tampil = input.type === 'password';
            input.type = tampil ? 'text' : 'password';
            this.textContent = tampil ? 'Sembunyikan' : 'Tampilkan';
        });
    </script>
    <script src="{{ asset('js/prevent-double-submit.js') }}"></script>
</body>
</html>