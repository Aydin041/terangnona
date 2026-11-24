@extends('layouts.auth')

@section('title', 'Lupa Kata Sandi Peserta')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-extrabold text-ink tracking-tight">Lupa Kata Sandi</h1>
        <p class="text-sm text-slate-500 mt-1">Masukkan alamat email akun peserta Anda untuk menerima tautan atur ulang kata sandi.</p>
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

    @if (session('sukses'))
        <div class="mb-5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm p-4 font-medium">
            {{ session('sukses') }}
        </div>
    @endif

    <form method="POST" action="{{ route('peserta.password.email') }}" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="block text-xs sm:text-sm font-bold text-ink mb-1.5">Alamat Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required autofocus
                class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-ink placeholder-slate-400 bg-white transition-all focus:outline-none focus:ring-2 focus:ring-brand-amber/30 focus:border-brand-amber shadow-sm">
        </div>

        <div>
            <label for="captcha" class="block text-xs sm:text-sm font-bold text-ink mb-1.5">Verifikasi Keamanan</label>
            <div class="mb-2 flex items-center gap-3">
                <img src="{{ captcha_src('login') }}" alt="Soal captcha" data-captcha-gambar
                    style="max-width:100%;height:auto" class="rounded-xl border border-slate-200 shadow-sm">
                <button type="button" data-captcha-muat-ulang class="text-xs font-semibold text-brand-blue hover:text-brand-blue-light underline transition-colors">
                    Ganti Soal
                </button>
            </div>
            <input type="text" id="captcha" name="captcha" inputmode="numeric" autocomplete="off" required placeholder="Hasil hitungan"
                class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-ink placeholder-slate-400 bg-white transition-all focus:outline-none focus:ring-2 focus:ring-brand-amber/30 focus:border-brand-amber shadow-sm">
        </div>

        <button type="submit"
            class="w-full bg-gradient-to-r from-brand-amber to-amber-500 hover:from-amber-400 hover:to-amber-500 text-brand-navy font-bold rounded-xl py-3.5 text-sm transition-all duration-200 shadow-md shadow-amber-500/15 active:scale-[0.99] mt-2">
            Kirim Tautan Atur Ulang
        </button>
    </form>

    <p class="text-center text-xs sm:text-sm text-slate-500 mt-6 pt-5 border-t border-slate-100">
        Ingat kata sandi Anda?
        <a href="{{ route('peserta.login') }}" class="font-bold text-brand-blue hover:text-brand-blue-light transition-colors">Masuk di sini</a>
    </p>

    <script>
        document.querySelectorAll('[data-captcha-muat-ulang]').forEach(function (tombol) {
            tombol.addEventListener('click', function () {
                const gambar = document.querySelector('[data-captcha-gambar]');
                gambar.src = gambar.src.split('?')[0] + '?' + Math.random().toString(36).slice(2);
                document.getElementById('captcha').value = '';
            });
        });
    </script>
@endsection
