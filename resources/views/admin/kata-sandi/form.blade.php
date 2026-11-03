@extends('layouts.admin')

@section('title', 'Ganti Kata Sandi')

@section('content')
    @php
        $kelas = 'w-full rounded-xl border border-line px-4 py-3 focus:outline-none focus:ring-2 focus:ring-brand-amber focus:border-brand-amber';
    @endphp

    <div class="max-w-xl">
        <p class="mb-3"><a href="{{ route('admin.pengaturan.form') }}" class="text-sm text-slate-500 hover:text-ink">← Kembali ke Pengaturan</a></p>
        <h1 class="text-2xl font-bold mb-2">Ganti Kata Sandi</h1>
        <p class="text-sm text-slate-500 mb-6">Mengganti kata sandi akun Admin Anda sendiri.</p>

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

        <form method="POST" action="{{ route('admin.kata-sandi.update') }}" class="space-y-4">
            @csrf

            <div class="bg-white border border-line rounded-2xl p-6 space-y-4">
                <div>
                    <label for="password_lama" class="block text-sm font-semibold mb-1.5">Kata sandi saat ini</label>
                    <input type="password" id="password_lama" name="password_lama" required autocomplete="current-password" class="{{ $kelas }}">
                </div>

                <div>
                    <label for="password_baru" class="block text-sm font-semibold mb-1.5">Kata sandi baru</label>
                    <input type="password" id="password_baru" name="password_baru" required minlength="10" autocomplete="new-password" class="{{ $kelas }}">
                    <p class="text-xs text-slate-400 mt-1.5">Minimal 10 karakter.</p>
                </div>

                <div>
                    <label for="password_baru_confirmation" class="block text-sm font-semibold mb-1.5">Ulangi kata sandi baru</label>
                    <input type="password" id="password_baru_confirmation" name="password_baru_confirmation" required minlength="10" autocomplete="new-password" class="{{ $kelas }}">
                </div>
            </div>

            <button type="submit" class="bg-brand-amber hover:bg-brand-amber-dark text-brand-navy font-semibold rounded-xl px-8 py-3 transition-colors">
                Simpan Kata Sandi
            </button>
        </form>
    </div>
@endsection