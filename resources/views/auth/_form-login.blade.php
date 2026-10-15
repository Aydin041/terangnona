<h1 class="text-2xl font-bold text-ink">{{ $judul }}</h1>
<p class="text-slate-500 mt-1 mb-6">{{ $subjudul }}</p>

@if ($errors->any())
    <div class="mb-5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm p-3">
        <ul class="list-disc list-inside space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('sukses'))
    <div class="mb-5 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm p-3">
        {{ session('sukses') }}
    </div>
@endif

<form method="POST" action="{{ $action }}" class="space-y-4">
    @csrf

    <div>
        <label for="email" class="block text-sm font-semibold text-ink mb-1.5">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required autofocus
            class="w-full rounded-xl border border-line px-4 py-3 text-ink placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-amber focus:border-brand-amber">
    </div>

    <div>
        <label for="password" class="block text-sm font-semibold text-ink mb-1.5">Password</label>
        <div class="relative">
            <input type="password" id="password" name="password" required
                class="w-full rounded-xl border border-line px-4 py-3 pr-28 text-ink focus:outline-none focus:ring-2 focus:ring-brand-amber focus:border-brand-amber">
            <button type="button" id="toggle-password"
                class="absolute right-4 top-1/2 -translate-y-1/2 text-sm text-slate-500 hover:text-ink">
                Tampilkan
            </button>
        </div>
    </div>

    <button type="submit"
        class="w-full bg-brand-amber hover:bg-brand-amber-dark text-brand-navy font-semibold rounded-xl py-3 transition-colors">
        Masuk
    </button>
</form>

@isset($daftar)
    <p class="text-center text-slate-500 mt-6">
        Belum punya akun?
        <a href="{{ $daftar }}" class="font-semibold text-brand-blue hover:underline">Daftar di sini</a>
    </p>
@endisset

<script>
    document.getElementById('toggle-password').addEventListener('click', function () {
        const input = document.getElementById('password');
        const tampil = input.type === 'password';
        input.type = tampil ? 'text' : 'password';
        this.textContent = tampil ? 'Sembunyikan' : 'Tampilkan';
    });
</script>