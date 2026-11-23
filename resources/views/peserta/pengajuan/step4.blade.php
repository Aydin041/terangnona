@extends('layouts.peserta')

@section('title', 'Pengajuan - Langkah 4')

@section('content')
    @php
        $kelasInput = 'w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-ink placeholder-slate-400 bg-white transition-all focus:outline-none focus:ring-2 focus:ring-brand-amber/30 focus:border-brand-amber shadow-2xs';
        $kelasKecil = 'w-full min-w-0 rounded-xl border border-slate-200 px-3.5 py-2.5 text-xs sm:text-sm text-ink placeholder-slate-400 bg-white transition-all focus:outline-none focus:ring-2 focus:ring-brand-amber/30 focus:border-brand-amber shadow-2xs';
    @endphp

    <div class="max-w-3xl mx-auto">
        <a href="{{ route('peserta.pengajuan.step3', $pengajuan->uuid) }}" class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-semibold text-slate-500 hover:text-brand-navy transition-colors mb-6 group">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Langkah 3
        </a>

        @include('peserta.pengajuan._stepper', ['langkah' => 4])

        <div class="mb-6">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-ink tracking-tight">Dokumen &amp; Isian Proposal</h1>
            <p class="text-sm text-slate-500 mt-1">{{ $pengajuan->nama_inovasi }} <span class="font-medium">({{ $pengajuan->akronim }})</span> &middot; Bentuk: <strong class="text-ink">{{ $pengajuan->nama_bentuk }}</strong></p>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-2xl bg-red-50/80 border border-red-200 text-red-700 text-xs sm:text-sm p-4">
                <ul class="list-disc list-inside space-y-1 font-medium">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('peserta.pengajuan.step4.submit', $pengajuan->uuid) }}" class="space-y-6">
            @csrf

            {{-- Bagian A: Dokumen Administratif --}}
            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-8 shadow-sm">
                <div class="flex items-center gap-2 mb-1">
                    <span class="w-2.5 h-2.5 rounded-full bg-brand-navy"></span>
                    <h2 class="font-bold text-ink text-lg">Bagian A — Dokumen Administratif</h2>
                </div>
                <p class="text-xs sm:text-sm text-slate-500 mb-6 leading-relaxed">
                    Semua dokumen dikirimkan dalam bentuk tautan (Google Drive/Cloud), tanpa mengunggah file lokal. Pastikan izin akses link diatur ke <em>"Siapa saja yang memiliki link dapat melihat"</em>.
                </p>

                <div class="space-y-5">
                    @include('peserta.pengajuan._input-tautan', [
                        'nama' => 'surat_identitas',
                        'label' => 'Link Surat Pernyataan Identitas Inovator',
                        'dok' => $dokumenTersimpan['surat_identitas'] ?? null,
                    ])

                    @if ($pengajuan->bentuk_inovasi === 'eksisting')
                        @include('peserta.pengajuan._input-tautan', [
                            'nama' => 'surat_implementasi',
                            'label' => 'Link Surat Pernyataan Implementasi Inovasi',
                            'dok' => $dokumenTersimpan['surat_implementasi'] ?? null,
                        ])
                    @else
                        @include('peserta.pengajuan._input-tautan', [
                            'nama' => 'surat_komitmen',
                            'label' => 'Link Surat Pernyataan Komitmen Implementasi Inovasi',
                            'dok' => $dokumenTersimpan['surat_komitmen'] ?? null,
                        ])
                    @endif

                    <div>
                        <label for="video_link" class="block text-xs sm:text-sm font-bold text-ink mb-1.5">Link Video Dampak Inovasi (YouTube / Google Drive)</label>
                        <input type="text" id="video_link" name="video_link"
                            value="{{ old('video_link', isset($dokumenTersimpan['video_link']) ? $dokumenTersimpan['video_link']->file_path : '') }}"
                            placeholder="https://youtu.be/... atau https://drive.google.com/..." required class="{{ $kelasInput }}">
                    </div>
                </div>
            </div>

            {{-- Bagian B: Isian Proposal --}}
            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-8 shadow-sm">
                <div class="flex items-center gap-2 mb-1">
                    <span class="w-2.5 h-2.5 rounded-full bg-brand-amber"></span>
                    <h2 class="font-bold text-ink text-lg">Bagian B — Isian Proposal ({{ count($komponenIsian) }} Komponen)</h2>
                </div>
                <p class="text-xs sm:text-sm text-slate-500 mb-6 leading-relaxed">
                    Tuliskan uraian inovasi dan sertakan minimal 1 tautan bukti dukung (data pendukung, foto, SK, atau laporan) untuk masing-masing kriteria.
                </p>

                <div class="space-y-6">
                    @foreach ($komponenIsian as $komponen)
                        @php $isianRow = $isianTersimpan[$komponen->id] ?? null; @endphp
                        <div class="border border-slate-200/80 rounded-2xl p-5 sm:p-6 bg-slate-50/40">
                            <div class="flex items-start justify-between gap-3 mb-4 flex-wrap">
                                <h3 class="font-bold text-ink text-base">{{ $komponen->nama }}</h3>
                                <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-blue-50 text-brand-blue border border-blue-200">Bobot {{ $komponen->bobot }}%</span>
                            </div>

                            <label class="block text-xs sm:text-sm font-bold text-ink mb-1.5">
                                Uraian Penjelasan Inovasi
                                @if ($komponen->jumlah_kata_maksimal)
                                    <span class="text-slate-400 font-normal">(Maksimal {{ $komponen->jumlah_kata_maksimal }} kata)</span>
                                @endif
                            </label>
                            <textarea name="uraian[{{ $komponen->id }}]" rows="4" placeholder="Jelaskan secara mendalam sesuai aspek komponen..." class="{{ $kelasInput }}">{{ old("uraian.{$komponen->id}", $isianRow->uraian ?? '') }}</textarea>

                            <div class="mt-4 pt-4 border-t border-slate-200/60">
                                <label class="block text-xs sm:text-sm font-bold text-ink mb-2">Tautan Bukti Dukung</label>
                                <div id="links-container-{{ $komponen->id }}" class="space-y-2.5">
                                    @php $linkList = $isianRow->links ?? collect(); @endphp
                                    @forelse ($linkList as $linkItem)
                                        <div class="flex flex-col sm:flex-row gap-2">
                                            <input type="text" name="link_judul[{{ $komponen->id }}][]" value="{{ $linkItem->judul }}" placeholder="Keterangan / Nama Dokumen" class="{{ $kelasKecil }} sm:flex-1">
                                            <input type="text" name="link_url[{{ $komponen->id }}][]" value="{{ $linkItem->link }}" placeholder="https://drive.google.com/..." class="{{ $kelasKecil }} sm:flex-[2]">
                                            <button type="button" onclick="this.parentElement.remove()" class="self-end sm:self-auto text-rose-600 hover:text-rose-800 hover:bg-rose-50 border border-rose-200 rounded-xl px-3 py-2 text-xs sm:text-sm font-bold transition-colors shrink-0">Hapus</button>
                                        </div>
                                    @empty
                                        <div class="flex flex-col sm:flex-row gap-2">
                                            <input type="text" name="link_judul[{{ $komponen->id }}][]" placeholder="Keterangan / Nama Dokumen" class="{{ $kelasKecil }} sm:flex-1">
                                            <input type="text" name="link_url[{{ $komponen->id }}][]" placeholder="https://drive.google.com/..." class="{{ $kelasKecil }} sm:flex-[2]">
                                            <button type="button" onclick="this.parentElement.remove()" class="self-end sm:self-auto text-rose-600 hover:text-rose-800 hover:bg-rose-50 border border-rose-200 rounded-xl px-3 py-2 text-xs sm:text-sm font-bold transition-colors shrink-0">Hapus</button>
                                        </div>
                                    @endforelse
                                </div>

                                <button type="button" onclick="tambahLinkRow({{ $komponen->id }})"
                                    class="mt-3 inline-flex items-center gap-1.5 text-xs font-bold text-brand-navy hover:text-brand-amber-dark border border-slate-200 hover:border-brand-amber rounded-xl px-3.5 py-1.5 transition-colors bg-white shadow-2xs">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                                    <span>Tambah Link Dokumen Lain</span>
                                </button>
                            </div>

                            @php
                                $jenisTambahan = \App\Http\Controllers\Peserta\PengajuanController::KOMPONEN_LAMPIRAN_TAMBAHAN[$komponen->id] ?? null;
                                $dokTambahan = $jenisTambahan ? ($dokumenTersimpan[$jenisTambahan] ?? null) : null;
                            @endphp
                            @if ($jenisTambahan)
                                <div class="mt-5 pt-4 border-t border-slate-200/80">
                                    @include('peserta.pengajuan._input-tautan', [
                                        'nama' => $jenisTambahan,
                                        'label' => 'Link Dokumen RAB',
                                        'dok' => $dokTambahan,
                                        'bantuan' => 'Semakin rinci rincian anggaran biaya (RAB), semakin baik bobot evaluasinya.',
                                    ])
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Bagian C: Lampiran Rencana Aksi (Jika ada) --}}
            @if (count($komponenLampiran) > 0)
                <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-8 shadow-sm">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-600"></span>
                        <h2 class="font-bold text-ink text-lg">Bagian C — Lampiran Rencana Aksi &amp; Anggaran</h2>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-500 mb-6">Tautan lampiran rencana aksi dan anggaran sesuai format resmi.</p>

                    <div class="space-y-4">
                        @foreach ($komponenLampiran as $komponen)
                            @php
                                $jenisDok = \App\Http\Controllers\Peserta\PengajuanController::KOMPONEN_LAMPIRAN[$komponen->id];
                                $dokTersimpan = $dokumenTersimpan[$jenisDok] ?? null;
                            @endphp
                            <div class="border border-slate-200/80 rounded-2xl p-5 bg-slate-50/40">
                                <p class="font-bold text-ink mb-3 text-sm sm:text-base">{{ $komponen->nama }} <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200 ml-1">Bobot {{ $komponen->bobot }}%</span></p>
                                @include('peserta.pengajuan._input-tautan', [
                                    'nama' => $jenisDok,
                                    'label' => 'Link Lampiran Google Drive',
                                    'dok' => $dokTersimpan,
                                ])
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="flex justify-end pt-2">
                <button type="submit" class="inline-flex items-center gap-2 bg-gradient-to-r from-brand-amber to-amber-500 hover:from-amber-400 hover:to-amber-500 text-brand-navy font-bold rounded-xl px-7 py-3.5 text-sm transition-all duration-200 shadow-md shadow-amber-500/15 active:scale-95">
                    <span>Simpan &amp; Lanjut ke Review</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </div>
        </form>
    </div>

    <script>
        function tambahLinkRow(komponenId) {
            const container = document.getElementById('links-container-' + komponenId);
            const div = document.createElement('div');
            div.className = 'flex flex-col sm:flex-row gap-2 animate-fadeIn';
            div.innerHTML = `
                <input type="text" name="link_judul[${komponenId}][]" placeholder="Keterangan / Nama Dokumen"
                    class="w-full min-w-0 rounded-xl border border-slate-200 px-3.5 py-2.5 text-xs sm:text-sm text-ink placeholder-slate-400 bg-white transition-all focus:outline-none focus:ring-2 focus:ring-brand-amber/30 focus:border-brand-amber shadow-2xs sm:flex-1">
                <input type="text" name="link_url[${komponenId}][]" placeholder="https://drive.google.com/..."
                    class="w-full min-w-0 rounded-xl border border-slate-200 px-3.5 py-2.5 text-xs sm:text-sm text-ink placeholder-slate-400 bg-white transition-all focus:outline-none focus:ring-2 focus:ring-brand-amber/30 focus:border-brand-amber shadow-2xs sm:flex-[2]">
                <button type="button" onclick="this.parentElement.remove()"
                    class="self-end sm:self-auto text-rose-600 hover:text-rose-800 hover:bg-rose-50 border border-rose-200 rounded-xl px-3 py-2 text-xs sm:text-sm font-bold transition-colors shrink-0">Hapus</button>
            `;
            container.appendChild(div);
        }
    </script>
@endsection
