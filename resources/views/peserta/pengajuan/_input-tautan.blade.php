<div>
    <label for="{{ $nama }}" class="block text-sm font-semibold mb-1.5">{{ $label }}</label>
    <input type="text" inputmode="url" id="{{ $nama }}" name="{{ $nama }}"
        value="{{ old($nama, ($dok && $dok->adalah_tautan) ? $dok->file_path : '') }}"
        placeholder="https://drive.google.com/..."
        class="w-full rounded-xl border border-line px-4 py-3 focus:outline-none focus:ring-2 focus:ring-brand-amber focus:border-brand-amber">
    @if ($dok && ! $dok->adalah_tautan)
        <p class="text-xs text-amber-700 mt-1.5">
            Berkas lama yang pernah diunggah: {{ $dok->label }}
            <a href="{{ $dok->tautan }}" target="_blank" rel="noopener noreferrer" class="underline">Lihat</a>.
            Isi tautan di atas untuk menggantinya.
        </p>
    @endif
    @isset($bantuan)
        <p class="text-xs text-slate-400 mt-1.5">{{ $bantuan }}</p>
    @endisset
</div>