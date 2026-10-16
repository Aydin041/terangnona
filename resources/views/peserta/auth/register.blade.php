@extends('layouts.auth')

@section('title', 'Registrasi Peserta')

@section('content')
    @php
        $kelas = 'w-full rounded-xl border border-line px-4 py-3 text-ink placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-amber focus:border-brand-amber';
    @endphp

    <h1 class="text-2xl font-bold text-ink">Registrasi Akun</h1>
    <p class="text-slate-500 mt-1 mb-6">Daftar sebagai peserta</p>

    @if ($errors->any())
        <div class="mb-5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm p-3">
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
            <label for="nama" class="block text-sm font-semibold text-ink mb-1.5">Nama Lengkap</label>
            <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required autofocus class="{{ $kelas }}">
        </div>

        <div>
            <label for="email" class="block text-sm font-semibold text-ink mb-1.5">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required class="{{ $kelas }}">
        </div>

        <div>
            <label for="kontak" class="block text-sm font-semibold text-ink mb-1.5">Nomor Kontak/WA</label>
            <input type="text" id="kontak" name="kontak" value="{{ old('kontak') }}" required class="{{ $kelas }}">
        </div>

        <div>
            <label for="password" class="block text-sm font-semibold text-ink mb-1.5">Password (minimal 8 karakter)</label>
            <div class="relative">
                <input type="password" id="password" name="password" required class="{{ $kelas }} pr-28">
                <button type="button" data-toggle="password"
                    class="absolute right-4 top-1/2 -translate-y-1/2 text-sm text-slate-500 hover:text-ink">Tampilkan</button>
            </div>
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-ink mb-1.5">Konfirmasi Password</label>
            <div class="relative">
                <input type="password" id="password_confirmation" name="password_confirmation" required class="{{ $kelas }} pr-28">
                <button type="button" data-toggle="password_confirmation"
                    class="absolute right-4 top-1/2 -translate-y-1/2 text-sm text-slate-500 hover:text-ink">Tampilkan</button>
            </div>
        </div>

        <button type="submit"
            class="w-full bg-brand-amber hover:bg-brand-amber-dark text-brand-navy font-semibold rounded-xl py-3 transition-colors">
            Daftar
        </button>
    </form>

    <p class="text-center text-slate-500 mt-6">
        Sudah punya akun?
        <a href="{{ route('peserta.login') }}" class="font-semibold text-brand-blue hover:underline">Login di sini</a>
    </p>

    <script>
        document.querySelectorAll('[data-toggle]').forEach(function (tombol) {
            tombol.addEventListener('click', function () {
                const input = document.getElementById(tombol.dataset.toggle);
                const tampil = input.type === 'password';
                input.type = tampil ? 'text' : 'password';
                tombol.textContent = tampil ? 'Sembunyikan' : 'Tampilkan';
            });
        });
    </script>
@endsection