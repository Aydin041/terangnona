{{-- Parameter: $kunci, $peran --}}
@php
    $kelas = 'w-full rounded-xl border border-line px-4 py-3 focus:outline-none focus:ring-2 focus:ring-brand-amber focus:border-brand-amber';
@endphp

<div class="max-w-lg">
    <p class="mb-3"><a href="{{ route('admin.akun.' . $kunci . '.index') }}" class="text-sm text-slate-500 hover:text-ink">← Kembali</a></p>

    <div class="bg-white border border-line rounded-2xl p-8">
        <h1 class="text-2xl font-bold mb-6">Tambah Akun {{ $peran }}</h1>

        @if ($errors->any())
            <div class="mb-5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm p-3">
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
                <label for="nama" class="block text-sm font-semibold mb-1.5">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required class="{{ $kelas }}">
            </div>

            <div>
                <label for="email" class="block text-sm font-semibold mb-1.5">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required class="{{ $kelas }}">
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold mb-1.5">Password <span class="font-normal text-slate-400">(opsional, kosongkan untuk dibuat otomatis)</span></label>
                <div class="relative">
                    <input type="password" id="password" name="password" minlength="6" autocomplete="new-password" class="{{ $kelas }} pr-28">
                    <button type="button" id="toggle-password" class="absolute right-4 top-1/2 -translate-y-1/2 text-sm text-slate-500 hover:text-ink">Tampilkan</button>
                </div>
            </div>

            <button type="submit" class="bg-brand-amber hover:bg-brand-amber-dark text-brand-navy font-semibold rounded-xl px-8 py-3 transition-colors">
                Buat Akun
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