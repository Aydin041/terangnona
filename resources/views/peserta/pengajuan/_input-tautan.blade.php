<div>
    <label for="{{ $nama }}" class="block text-xs sm:text-sm font-bold text-ink mb-1.5">{{ $label }}</label>
    <div class="relative">
        <input type="text" inputmode="url" id="{{ $nama }}" name="{{ $nama }}"
            value="{{ old($nama, ($dok && $dok->adalah_tautan) ? $dok->file_path : '') }}"
            placeholder="https://drive.google.com/..."
            class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-ink placeholder-slate-400 bg-white transition-all focus:outline-none focus:ring-2 focus:ring-brand-amber/30 focus:border-brand-amber shadow-2xs">
    </div>
    @if ($dok && ! $dok->adalah_tautan)
        <p class="text-xs text-amber-800 bg-amber-50 rounded-lg p-2 mt-2 border border-amber-200">
            Berkas lampiran lama: <strong class="font-semibold">{{ $dok->label }}</strong>
            (<a href="{{ $dok->tautan }}" target="_blank" rel="noopener noreferrer" class="underline font-bold text-brand-blue">Buka Berkas</a>).
            Isi tautan Google Drive baru di atas untuk memperbaruinya.
        </p>
    @endif
    @isset($bantuan)
        <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">{{ $bantuan }}</p>
    @endisset
</div>
