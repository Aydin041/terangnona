<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pengajuan - Langkah 4 - TERANG NONA</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-stone-50 min-h-screen">

    <nav class="bg-white border-b border-stone-200">
        <div class="max-w-2xl mx-auto px-4 py-3">
            <a href="{{ route('peserta.dashboard') }}">
                <img src="{{ asset('images/logo-terang-nona-transparan.png') }}" alt="TERANG NONA" class="h-10">
            </a>
            <span class="text-sm text-slate-500">Login sebagai: <strong class="text-slate-700">{{ Auth::guard('peserta')->user()->nama }}</strong></span>
        </div>
    </nav>

    <main class="max-w-2xl mx-auto px-4 py-8">
        <p class="mb-3"><a href="{{ route('peserta.pengajuan.step3', $pengajuan->id) }}" class="text-sm text-slate-500 hover:text-slate-900">← Kembali ke Langkah 3</a></p>
        <div class="flex items-center gap-2 mb-2">
            @for ($i = 1; $i <= 5; $i++)
                <div class="h-1.5 flex-1 rounded-full {{ $i <= 4 ? 'bg-amber-500' : 'bg-stone-200' }}"></div>
            @endfor
        </div>
        <p class="text-xs text-slate-500 mb-5">Langkah 4 dari 5</p>

        <h1 class="text-xl font-bold text-slate-900">Dokumen & Isian Proposal</h1>
        <p class="text-slate-500 text-sm mb-5">{{ $pengajuan->nama_inovasi }} ({{ $pengajuan->akronim }}) — Bentuk: {{ $pengajuan->bentuk_inovasi }}</p>

        @if ($errors->any())
            <div class="mb-4 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm p-3">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('peserta.pengajuan.step4.submit', $pengajuan->id) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="bg-white border border-stone-200 rounded-xl p-6">
                <h2 class="font-semibold text-slate-900 mb-4">Bagian A — Dokumen Administratif</h2>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Surat Pernyataan Identitas Inovator (PDF)</label>
                        @if (isset($dokumenTersimpan['surat_identitas']))
                            <p class="text-xs text-green-700 mb-1">Sudah diupload: {{ $dokumenTersimpan['surat_identitas']->nama_asli }}
                                <a href="{{ asset('storage/' . $dokumenTersimpan['surat_identitas']->file_path) }}" target="_blank" class="underline">Lihat</a>
                            </p>
                        @endif
                        <input type="file" name="surat_identitas" accept="application/pdf"
                            class="block w-full text-sm text-slate-600 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:bg-stone-100 file:text-slate-700 hover:file:bg-stone-200">
                    </div>

                    @if ($pengajuan->bentuk_inovasi === 'eksisting')
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Surat Pernyataan Implementasi Inovasi (PDF)</label>
                            @if (isset($dokumenTersimpan['surat_implementasi']))
                                <p class="text-xs text-green-700 mb-1">Sudah diupload: {{ $dokumenTersimpan['surat_implementasi']->nama_asli }}
                                    <a href="{{ asset('storage/' . $dokumenTersimpan['surat_implementasi']->file_path) }}" target="_blank" class="underline">Lihat</a>
                                </p>
                            @endif
                            <input type="file" name="surat_implementasi" accept="application/pdf"
                                class="block w-full text-sm text-slate-600 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:bg-stone-100 file:text-slate-700 hover:file:bg-stone-200">
                        </div>
                    @else
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Surat Pernyataan Komitmen Implementasi Inovasi (PDF)</label>
                            @if (isset($dokumenTersimpan['surat_komitmen']))
                                <p class="text-xs text-green-700 mb-1">Sudah diupload: {{ $dokumenTersimpan['surat_komitmen']->nama_asli }}
                                    <a href="{{ asset('storage/' . $dokumenTersimpan['surat_komitmen']->file_path) }}" target="_blank" class="underline">Lihat</a>
                                </p>
                            @endif
                            <input type="file" name="surat_komitmen" accept="application/pdf"
                                class="block w-full text-sm text-slate-600 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:bg-stone-100 file:text-slate-700 hover:file:bg-stone-200">
                        </div>
                    @endif

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Link Video Dampak Inovasi (YouTube/Drive/dll)</label>
                        <input type="text" name="video_link"
                            value="{{ isset($dokumenTersimpan['video_link']) ? $dokumenTersimpan['video_link']->file_path : old('video_link') }}"
                            placeholder="https://..." required
                            class="w-full rounded-lg border border-stone-300 px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                    </div>
                </div>
            </div>

            <div class="bg-white border border-stone-200 rounded-xl p-6">
                <h2 class="font-semibold text-slate-900 mb-1">Bagian B — Isian Proposal ({{ count($komponenIsian) }} Komponen)</h2>
                <p class="text-sm text-slate-500 mb-4">Isi uraian jawaban dan minimal 1 link bukti dukung (link Drive/dokumen pendukung) untuk setiap komponen di bawah. Bisa tambah lebih dari 1 link kalau perlu.</p>

                <div class="space-y-4">
                    @foreach ($komponenIsian as $komponen)
                        @php $isianRow = $isianTersimpan[$komponen->id] ?? null; @endphp
                        <div class="border border-stone-200 rounded-lg p-4">
                            <p class="font-medium text-slate-900 mb-3">{{ $komponen->nama }} <span class="text-slate-400 font-normal">(Bobot {{ $komponen->bobot }}%)</span></p>

                            <label class="block text-sm font-medium text-slate-700 mb-1">
                                Uraian/Isian Inovasi
                                @if ($komponen->jumlah_kata_maksimal)
                                    <span class="text-slate-400 font-normal">(Maksimal {{ $komponen->jumlah_kata_maksimal }} kata)</span>
                                @endif
                            </label>
                            <textarea name="uraian[{{ $komponen->id }}]" rows="4"
                                class="w-full rounded-lg border border-stone-300 px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500">{{ old("uraian.{$komponen->id}", $isianRow->uraian ?? '') }}</textarea>

                            <label class="block text-sm font-medium text-slate-700 mb-1 mt-3">Link/Tautan Bukti Dukung</label>
                            <div id="links-container-{{ $komponen->id }}" class="space-y-2">
                                @php $linkList = $isianRow->links ?? collect(); @endphp
                                @forelse ($linkList as $linkItem)
                                    <div class="flex flex-col sm:flex-row gap-2">
                                        <input type="text" name="link_judul[{{ $komponen->id }}][]" value="{{ $linkItem->judul }}" placeholder="Judul"
                                            class="w-full min-w-0 sm:flex-1 rounded-lg border border-stone-300 px-3 py-2 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                                        <input type="text" name="link_url[{{ $komponen->id }}][]" value="{{ $linkItem->link }}" placeholder="https://..."
                                            class="w-full min-w-0 sm:flex-[2] rounded-lg border border-stone-300 px-3 py-2 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                                        <button type="button" onclick="this.parentElement.remove()"
                                            class="self-end sm:self-auto text-red-600 hover:text-red-800 border border-red-200 rounded-lg px-3 py-2 sm:py-0 text-sm">−</button>
                                    </div>
                                @empty
                                    <div class="flex flex-col sm:flex-row gap-2">
                                        <input type="text" name="link_judul[{{ $komponen->id }}][]" placeholder="Judul"
                                            class="w-full min-w-0 sm:flex-1 rounded-lg border border-stone-300 px-3 py-2 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                                        <input type="text" name="link_url[{{ $komponen->id }}][]" placeholder="https://..."
                                            class="w-full min-w-0 sm:flex-[2] rounded-lg border border-stone-300 px-3 py-2 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                                        <button type="button" onclick="this.parentElement.remove()"
                                            class="self-end sm:self-auto text-red-600 hover:text-red-800 border border-red-200 rounded-lg px-3 py-2 sm:py-0 text-sm">−</button>
                                    </div>
                                @endforelse
                            </div>
                            <button type="button" onclick="tambahLinkRow({{ $komponen->id }})"
                                class="mt-2 text-sm text-amber-700 border border-amber-300 rounded-lg px-3 py-1.5 hover:bg-amber-50">
                                + Tambah Link
                            </button>

                            @php
                                $jenisTambahan = \App\Http\Controllers\Peserta\PengajuanController::KOMPONEN_LAMPIRAN_TAMBAHAN[$komponen->id] ?? null;
                                $dokTambahan = $jenisTambahan ? ($dokumenTersimpan[$jenisTambahan] ?? null) : null;
                            @endphp
                            @if ($jenisTambahan)
                                <div class="mt-4 pt-4 border-t border-stone-200">
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Upload Dokumen RAB (PDF)</label>
                                    @if ($dokTambahan)
                                        <p class="text-xs text-green-700 mb-1">Sudah diupload: {{ $dokTambahan->nama_asli }}
                                            <a href="{{ asset('storage/' . $dokTambahan->file_path) }}" target="_blank" class="underline">Lihat</a>
                                        </p>
                                    @endif
                                    <input type="file" name="{{ $jenisTambahan }}" accept="application/pdf"
                                        class="block w-full text-sm text-slate-600 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:bg-stone-100 file:text-slate-700 hover:file:bg-stone-200">
                                    <p class="text-xs text-slate-400 mt-1">Semakin rinci RAB-nya, semakin besar peluang nilai bagus.</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            @if (count($komponenLampiran) > 0)
                <div class="bg-white border border-stone-200 rounded-xl p-6">
                    <h2 class="font-semibold text-slate-900 mb-1">Bagian C — Lampiran Rencana Aksi & Rencana Anggaran</h2>
                    <p class="text-sm text-slate-500 mb-4">Untuk 2 komponen ini, isian berupa lampiran PDF (bukan uraian teks), sesuai form resmi.</p>

                    <div class="space-y-4">
                        @foreach ($komponenLampiran as $komponen)
                            @php
                                $jenisDok = \App\Http\Controllers\Peserta\PengajuanController::KOMPONEN_LAMPIRAN[$komponen->id];
                                $dokTersimpan = $dokumenTersimpan[$jenisDok] ?? null;
                            @endphp
                            <div class="border border-stone-200 rounded-lg p-4">
                                <p class="font-medium text-slate-900 mb-2">{{ $komponen->nama }} <span class="text-slate-400 font-normal">(Bobot {{ $komponen->bobot }}%)</span></p>
                                @if ($dokTersimpan)
                                    <p class="text-xs text-green-700 mb-1">Sudah diupload: {{ $dokTersimpan->nama_asli }}
                                        <a href="{{ asset('storage/' . $dokTersimpan->file_path) }}" target="_blank" class="underline">Lihat</a>
                                    </p>
                                @endif
                                <label class="block text-sm font-medium text-slate-700 mb-1">Upload Lampiran (PDF)</label>
                                <input type="file" name="{{ $jenisDok }}" accept="application/pdf"
                                    class="block w-full text-sm text-slate-600 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:bg-stone-100 file:text-slate-700 hover:file:bg-stone-200">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <button type="submit"
                class="w-full bg-amber-500 hover:bg-amber-600 text-slate-900 font-semibold rounded-lg py-2.5 transition-colors">
                Simpan & Lanjut ke Langkah 5
            </button>
        </form>
    </main>

    <script>
        function tambahLinkRow(komponenId) {
            const container = document.getElementById('links-container-' + komponenId);
            const div = document.createElement('div');
            div.className = 'flex flex-col sm:flex-row gap-2';
            div.innerHTML = `
                <input type="text" name="link_judul[${komponenId}][]" placeholder="Judul"
                    class="w-full min-w-0 sm:flex-1 rounded-lg border border-stone-300 px-3 py-2 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                <input type="text" name="link_url[${komponenId}][]" placeholder="https://..."
                    class="w-full min-w-0 sm:flex-[2] rounded-lg border border-stone-300 px-3 py-2 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                <button type="button" onclick="this.parentElement.remove()"
                    class="self-end sm:self-auto text-red-600 hover:text-red-800 border border-red-200 rounded-lg px-3 py-2 sm:py-0 text-sm">−</button>
            `;
            container.appendChild(div);
        }
    </script>
    <script src="{{ asset('js/prevent-double-submit.js') }}"></script>
</body>
</html>