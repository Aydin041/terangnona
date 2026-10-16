<div>
    <label for="{{ $nama }}" class="block text-sm font-medium text-slate-700 mb-1">{{ $label }}</label>
    <input type="text" inputmode="url" id="{{ $nama }}" name="{{ $nama }}"
        value="{{ old($nama, ($dok && $dok->adalah_tautan) ? $dok->file_path : '') }}"
        placeholder="https://drive.google.com/..."
        class="w-full rounded-lg border border-stone-300 px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
    @if ($dok && ! $dok->adalah_tautan)
        <p class="text-xs text-amber-700 mt-1">
            Berkas lama yang pernah diunggah: {{ $dok->label }}
            <a href="{{ $dok->tautan }}" target="_blank" rel="noopener noreferrer" class="underline">Lihat</a>.
            Isi tautan di atas untuk menggantinya.
        </p>
    @endif
    @isset($bantuan)
        <p class="text-xs text-slate-400 mt-1">{{ $bantuan }}</p>
    @endisset
</div>