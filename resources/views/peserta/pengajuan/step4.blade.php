@extends('layouts.peserta')

@section('title', 'Pengajuan - Langkah 4')

@section('content')
    @php
        $kelas = 'w-full rounded-xl border border-line px-4 py-3 focus:outline-none focus:ring-2 focus:ring-brand-amber focus:border-brand-amber';
        $kelasKecil = 'w-full min-w-0 rounded-xl border border-line px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-amber focus:border-brand-amber';
    @endphp

    <div class="max-w-3xl mx-auto">
        <p class="mb-4"><a href="{{ route('peserta.pengajuan.step3', $pengajuan->id) }}" class="text-sm text-slate-500 hover:text-ink">← Kembali ke Langkah 3</a></p>

        @include('peserta.pengajuan._stepper', ['langkah' => 4])

        <h1 class="text-2xl font-bold">Dokumen & Isian Proposal</h1>
        <p class="text-slate-500 mt-1 mb-5">{{ $pengajuan->nama_inovasi }} ({{ $pengajuan->akronim }}) — Bentuk: {{ $pengajuan->bentuk_inovasi }}</p>

        @if ($errors->any())
            <div class="mb-5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm p-3">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('peserta.pengajuan.step4.submit', $pengajuan->id) }}" class="space-y-6">
            @csrf

            <div class="bg-white border border-line rounded-2xl p-6">
                <h2 class="font-semibold mb-1">Bagian A — Dokumen Administratif</h2>
                <p class="text-sm text-slate-500 mb-5">Semua dokumen dikirim berupa tautan, tanpa mengunggah berkas. Pastikan akses tautan diatur "Siapa saja yang memiliki link" agar Panitia dan Juri dapat membukanya.</p>

                <div class="space-y-4">
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
                        <label for="video_link" class="block text-sm font-semibold mb-1.5">Link Video Dampak Inovasi (YouTube/Drive/dll)</label>
                        <input type="text" id="video_link" name="video_link"
                            value="{{ old('video_link', isset($dokumenTersimpan['video_link']) ? $dokumenTersimpan['video_link']->file_path : '') }}"
                            placeholder="https://..." required class="{{ $kelas }}">
                    </div>
                </div>
            </div>

            <div class="bg-white border border-line rounded-2xl p-6">
                <h2 class="font-semibold mb-1">Bagian B — Isian Proposal ({{ count($komponenIsian) }} Komponen)</h2>
                <p class="text-sm text-slate-500 mb-5">Isi uraian jawaban dan minimal 1 link bukti dukung (link Drive/dokumen pendukung) untuk setiap komponen di bawah. Bisa tambah lebih dari 1 link kalau perlu.</p>

                <div class="space-y-4">
                    @foreach ($komponenIsian as $komponen)
                        @php $isianRow = $isianTersimpan[$komponen->id] ?? null; @endphp
                        <div class="border border-line rounded-xl p-5">
                            <p class="font-semibold mb-3">{{ $komponen->nama }} <span class="text-slate-400 font-normal text-sm">(Bobot {{ $komponen->bobot }}%)</span></p>

                            <label class="block text-sm font-semibold mb-1.5">
                                Uraian/Isian Inovasi
                                @if ($komponen->jumlah_kata_maksimal)
                                    <span class="text-slate-400 font-normal">(Maksimal {{ $komponen->jumlah_kata_maksimal }} kata)</span>
                                @endif
                            </label>
                            <textarea name="uraian[{{ $komponen->id }}]" rows="4" class="{{ $kelas }}">{{ old("uraian.{$komponen->id}", $isianRow->uraian ?? '') }}</textarea>

                            <label class="block text-sm font-semibold mb-1.5 mt-4">Link/Tautan Bukti Dukung</label>
                            <div id="links-container-{{ $komponen->id }}" class="space-y-2">
                                @php $linkList = $isianRow->links ?? collect(); @endphp
                                @forelse ($linkList as $linkItem)
                                    <div class="flex flex-col sm:flex-row gap-2">
                                        <input type="text" name="link_judul[{{ $komponen->id }}][]" value="{{ $linkItem->judul }}" placeholder="Judul" class="{{ $kelasKecil }} sm:flex-1">
                                        <input type="text" name="link_url[{{ $komponen->id }}][]" value="{{ $linkItem->link }}" placeholder="https://..." class="{{ $kelasKecil }} sm:flex-[2]">
                                        <button type="button" onclick="this.parentElement.remove()" class="self-end sm:self-auto text-red-600 hover:text-red-800 border border-red-200 rounded-xl px-3 py-2 text-sm">−</button>
                                    </div>
                                @empty
                                    <div class="flex flex-col sm:flex-row gap-2">
                                        <input type="text" name="link_judul[{{ $komponen->id }}][]" placeholder="Judul" class="{{ $kelasKecil }} sm:flex-1">
                                        <input type="text" name="link_url[{{ $komponen->id }}][]" placeholder="https://..." class="{{ $kelasKecil }} sm:flex-[2]">
                                        <button type="button" onclick="this.parentElement.remove()" class="self-end sm:self-auto text-red-600 hover:text-red-800 border border-red-200 rounded-xl px-3 py-2 text-sm">−</button>
                                    </div>
                                @endforelse
                            </div>
                            <button type="button" onclick="tambahLinkRow({{ $komponen->id }})"
                                class="mt-2 text-sm font-medium text-brand-amber-dark border border-amber-300 rounded-xl px-4 py-1.5 hover:bg-amber-50 transition-colors">
                                + Tambah Link
                            </button>

                            @php
                                $jenisTambahan = \App\Http\Controllers\Peserta\PengajuanController::KOMPONEN_LAMPIRAN_TAMBAHAN[$komponen->id] ?? null;
                                $dokTambahan = $jenisTambahan ? ($dokumenTersimpan[$jenisTambahan] ?? null) : null;
                            @endphp
                            @if ($jenisTambahan)
                                <div class="mt-5 pt-5 border-t border-line">
                                    @include('peserta.pengajuan._input-tautan', [
                                        'nama' => $jenisTambahan,
                                        'label' => 'Link Dokumen RAB',
                                        'dok' => $dokTambahan,
                                        'bantuan' => 'Semakin rinci RAB-nya, semakin besar peluang nilai bagus.',
                                    ])
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            @if (count($komponenLampiran) > 0)
                <div class="bg-white border border-line rounded-2xl p-6">
                    <h2 class="font-semibold mb-1">Bagian C — Lampiran Rencana Aksi & Rencana Anggaran</h2>
                    <p class="text-sm text-slate-500 mb-5">Isian untuk komponen ini berupa tautan lampiran (bukan uraian teks), sesuai form resmi.</p>

                    <div class="space-y-4">
                        @foreach ($komponenLampiran as $komponen)
                            @php
                                $jenisDok = \App\Http\Controllers\Peserta\PengajuanController::KOMPONEN_LAMPIRAN[$komponen->id];
                                $dokTersimpan = $dokumenTersimpan[$jenisDok] ?? null;
                            @endphp
                            <div class="border border-line rounded-xl p-5">
                                <p class="font-semibold mb-3">{{ $komponen->nama }} <span class="text-slate-400 font-normal text-sm">(Bobot {{ $komponen->bobot }}%)</span></p>
                                @include('peserta.pengajuan._input-tautan', [
                                    'nama' => $jenisDok,
                                    'label' => 'Link Lampiran',
                                    'dok' => $dokTersimpan,
                                ])
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="flex justify-end">
                <button type="submit" class="bg-brand-amber hover:bg-brand-amber-dark text-brand-navy font-semibold rounded-xl px-8 py-3 transition-colors">
                    Simpan & Lanjut ke Langkah 5
                </button>
            </div>
        </form>
    </div>

    <script>
        function tambahLinkRow(komponenId) {
            const container = document.getElementById('links-container-' + komponenId);
            const div = document.createElement('div');
            div.className = 'flex flex-col sm:flex-row gap-2';
            div.innerHTML = `
                <input type="text" name="link_judul[${komponenId}][]" placeholder="Judul"
                    class="w-full min-w-0 rounded-xl border border-line px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-amber focus:border-brand-amber sm:flex-1">
                <input type="text" name="link_url[${komponenId}][]" placeholder="https://..."
                    class="w-full min-w-0 rounded-xl border border-line px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-amber focus:border-brand-amber sm:flex-[2]">
                <button type="button" onclick="this.parentElement.remove()"
                    class="self-end sm:self-auto text-red-600 hover:text-red-800 border border-red-200 rounded-xl px-3 py-2 text-sm">−</button>
            `;
            container.appendChild(div);
        }
    </script>
@endsection