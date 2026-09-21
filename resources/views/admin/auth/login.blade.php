<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin - TERANG NONA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-stone-50 min-h-screen flex items-center justify-center px-4 py-10">

    <div class="w-full max-w-sm">
        <div class="text-center mb-6">
            <a href="{{ route('landing') }}" class="inline-block">
                <img src="{{ asset('images/logo-terang-nona-transparan.png') }}" alt="TERANG NONA" class="h-20 mx-auto">
            </a>
            <p class="text-slate-500 text-sm mt-1">Masuk sebagai Admin</p>
        </div>

        <div class="bg-white border border-stone-200 border-t-4 border-t-amber-500 rounded-xl p-6 shadow-sm">
            <h1 class="text-xl font-bold text-slate-900 mb-5">Login Admin</h1>

            @if ($errors->any())
                <div class="mb-4 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm p-3">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full rounded-lg border border-stone-300 px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                    <div class="relative">
                        <input type="password" name="password" required
                            class="w-full rounded-lg border border-stone-300 px-3 py-2 pr-10 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                        <button type="button"
                            onclick="const i=this.previousElementSibling; i.type = i.type==='password'?'text':'password'; this.querySelector('.mata-buka').classList.toggle('hidden'); this.querySelector('.mata-tutup').classList.toggle('hidden');"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                            <svg class="mata-buka w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg class="mata-tutup w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"/></svg>
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

    <script src="{{ asset('js/prevent-double-submit.js') }}"></script>
</body>
</html>