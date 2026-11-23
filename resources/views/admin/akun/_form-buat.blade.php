{{-- Parameter: $kunci, $peran --}}
@php
    $kelasInput = 'w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-ink placeholder-slate-400 bg-white transition-all focus:outline-none focus:ring-2 focus:ring-brand-amber/30 focus:border-brand-amber shadow-2xs';
@endphp

<div class="max-w-lg">
    <a href="{{ route('admin.akun.' . $kunci . '.index') }}" class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-semibold text-slate-500 hover:text-brand-navy transition-colors mb-6 group">
        <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali ke Daftar Akun
    </a>

    <div class="bg-white border border-slate-200/80 rounded-3xl p-7 sm:p-9 shadow-sm">
        <div class="mb-6">
            <h1 class="text-2xl font-extrabold text-ink tracking-tight">Tambah Akun {{ $peran }}</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Buat kredensial akun baru untuk hak akses {{ $peran }}.</p>
        </div>

        @if ($errors->any())
            <div class="mb-5 rounded-2xl bg-red-50/80 border border-red-200 text-red-700 text-xs sm:text-sm p-4 font-medium">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.akun.' . $kunci . '.store') }}" class="space-y-4">
            @csrf

            <div>
                <label for="nama" class="block text-xs sm:text-sm font-bold text-ink mb-1.5">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required placeholder="Nama lengkap personil" class="{{ $kelasInput }}">
            </div>

            <div>
                <label for="email" class="block text-xs sm:text-sm font-bold text-ink mb-1.5">Alamat Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="email@instansi.go.id" class="{{ $kelasInput }}">
            </div>

            <div>
                <label for="password" class="block text-xs sm:text-sm font-bold text-ink mb-1.5">Kata Sandi Awal</label>
                <div class="relative">
                    <input type="password" id="password" name="password" minlength="6" autocomplete="new-password" placeholder="Kosongkan untuk generate acak" class="{{ $kelasInput }} pr-24">
                    <button type="button" id="toggle-password" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-xs font-semibold text-slate-500 hover:text-brand-navy px-1.5 py-1 rounded transition-colors">Tampilkan</button>
                </div>
                <p class="text-2xs sm:text-xs text-slate-400 mt-1.5">Jika dikosongkan, kata sandi acak akan dibuatkan otomatis oleh sistem.</p>
            </div>

            <button type="submit" class="w-full mt-4 bg-gradient-to-r from-brand-amber to-amber-500 hover:from-amber-400 hover:to-amber-500 text-brand-navy font-bold rounded-xl py-3.5 text-sm transition-all duration-200 shadow-md shadow-amber-500/15 active:scale-95">
                Buat Akun Sekarang
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
