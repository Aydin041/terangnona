{{-- Parameter: $kunci (panitia/juri/peserta/pimpinan), $peran (label), $daftar, $bolehTambah, $catatan (opsional), $tampilKontak (opsional) --}}
@include('admin.akun._tab')

<div class="flex items-start justify-between gap-4 flex-wrap mb-5">
    <div>
        <h1 class="text-2xl font-bold">Kelola Akun {{ $peran }}</h1>
        @isset($catatan)
            <p class="text-sm text-slate-500 mt-1 max-w-xl">{{ $catatan }}</p>
        @endisset
    </div>
    @if ($bolehTambah)
        <a href="{{ route('admin.akun.' . $kunci . '.create') }}"
            class="bg-brand-amber hover:bg-brand-amber-dark text-brand-navy font-semibold rounded-xl px-5 py-2.5 transition-colors">
            + Tambah Akun {{ $peran }}
        </a>
    @endif
</div>

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
    <div class="mb-5 rounded-xl bg-green-50 border border-green-200 text-green-800 text-sm p-4 break-words">
        {{ session('sukses') }}
    </div>
@endif

@if ($daftar->isEmpty())
    <div class="bg-white border border-line rounded-2xl p-8 text-center text-slate-500">
        Belum ada akun {{ $peran }}.
    </div>
@else
    <div class="space-y-3">
        @foreach ($daftar as $item)
            <div class="bg-white border border-line rounded-2xl p-5 flex items-center justify-between flex-wrap gap-3">
                <div class="min-w-0">
                    <p class="font-semibold">{{ $item->nama }}</p>
                    <p class="text-sm text-slate-500 break-all">{{ $item->email }}@if (! empty($tampilKontak) && $item->kontak) | {{ $item->kontak }}@endif</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.akun.' . $kunci . '.reset.form', $item->id) }}"
                        class="text-sm font-medium border border-line hover:border-brand-amber rounded-xl px-4 py-2 transition-colors">
                        Reset Password
                    </a>
                    <form method="POST" action="{{ route('admin.akun.' . $kunci . '.hapus', $item->id) }}"
                        data-pesan="Yakin mau hapus akun {{ $peran }} {{ $item->nama }}? Tidak bisa dikembalikan."
                        onsubmit="return confirm(this.dataset.pesan);">
                        @csrf
                        <button type="submit" class="text-sm font-medium border border-red-300 text-red-700 hover:bg-red-50 rounded-xl px-4 py-2 transition-colors">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endif