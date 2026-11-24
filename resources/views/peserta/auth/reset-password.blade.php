@extends('layouts.auth')

@section('title', 'Buat Kata Sandi Baru')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-extrabold text-ink tracking-tight">Atur Ulang Kata Sandi</h1>
        <p class="text-sm text-slate-500 mt-1">Buat kata sandi baru yang kuat untuk akun Anda.</p>
    </div>

    @if ($errors->any())
        <div class="mb-5 rounded-2xl bg-red-50/80 border border-red-200 text-red-700 text-xs sm:text-sm p-4">
            <ul class="list-disc list-inside space-y-1 font-medium">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('peserta.password.update') }}" class="space-y-4">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">

        <div>
            <label for="email_display" class="block text-xs sm:text-sm font-bold text-ink mb-1.5">Alamat Email</label>
            <input type="email" id="email_display" value="{{ $email }}" disabled
                class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-500 bg-slate-50 shadow-sm cursor-not-allowed">
        </div>

        <div>
            <label for="password" class="block text-xs sm:text-sm font-bold text-ink mb-1.5">Kata Sandi Baru</label>
            <div class="relative">
                <input type="password" id="password" name="password" required placeholder="Minimal 8 karakter"
                    class="w-full rounded-xl border border-slate-200 px-4 py-3 pr-24 text-sm text-ink placeholder-slate-400 bg-white transition-all focus:outline-none focus:ring-2 focus:ring-brand-amber/30 focus:border-brand-amber shadow-sm">
                <button type="button" id="toggle-password"
                    class="absolute right-3.5 top-1/2 -translate-y-1/2 text-xs font-semibold text-slate-500 hover:text-brand-navy px-1.5 py-1 rounded transition-colors">
                    Tampilkan
                </button>
            </div>
        </div>

        <div>
            <label for="password_confirmation" class="block text-xs sm:text-sm font-bold text-ink mb-1.5">Konfirmasi Kata Sandi Baru</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Ulangi kata sandi baru"
                class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-ink placeholder-slate-400 bg-white transition-all focus:outline-none focus:ring-2 focus:ring-brand-amber/30 focus:border-brand-amber shadow-sm">
        </div>

        <button type="submit"
            class="w-full bg-gradient-to-r from-brand-amber to-amber-500 hover:from-amber-400 hover:to-amber-500 text-brand-navy font-bold rounded-xl py-3.5 text-sm transition-all duration-200 shadow-md shadow-amber-500/15 active:scale-[0.99] mt-2">
            Simpan Kata Sandi Baru
        </button>
    </form>

    <script>
        document.getElementById('toggle-password').addEventListener('click', function () {
            const input = document.getElementById('password');
            const tampil = input.type === 'password';
            input.type = tampil ? 'text' : 'password';
            this.textContent = tampil ? 'Sembunyikan' : 'Tampilkan';
        });
    </script>
@endsection
