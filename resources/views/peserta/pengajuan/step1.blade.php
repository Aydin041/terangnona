<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengajuan - Langkah 1 - TERANG NONA</title>
</head>
<body>
    <h1>{{ $pengajuan ? 'Perbaiki Pengajuan' : 'Pengajuan Baru' }} — Langkah 1/5: Profil Inovasi</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ $pengajuan ? route('peserta.pengajuan.step1.update', $pengajuan->id) : route('peserta.pengajuan.step1.submit') }}">
        @csrf

        <div>
            <label>Nama Inovasi</label><br>
            <input type="text" name="nama_inovasi" value="{{ old('nama_inovasi', $pengajuan->nama_inovasi ?? '') }}" required>
        </div>

        <div>
            <label>Akronim</label><br>
            <input type="text" name="akronim" value="{{ old('akronim', $pengajuan->akronim ?? '') }}" placeholder="contoh: PANDU GUNUNG" required>
        </div>

        <div>
            <label>Kategori</label><br>
            <select name="kategori_id" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach ($kategoriList as $kategori)
                    <option value="{{ $kategori->id }}"
                        {{ old('kategori_id', $pengajuan->kategori_id ?? '') == $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label>Unit Kerja Pengampu Inovasi</label><br>
            <select name="unit_kerja_id" required>
                <option value="">-- Pilih Unit Kerja --</option>
                @foreach ($unitKerjaList as $unit)
                    <option value="{{ $unit->id }}"
                        {{ old('unit_kerja_id', $pengajuan->unit_kerja_id ?? '') == $unit->id ? 'selected' : '' }}>
                        {{ $unit->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label>Tahun Implementasi/Rencana</label><br>
            <input type="number" name="tahun_implementasi" value="{{ old('tahun_implementasi', $pengajuan->tahun_implementasi ?? 2026) }}" required>
        </div>

        <button type="submit">Lanjut ke Langkah 2</button>
    </form>
    <script src="{{ asset('js/prevent-double-submit.js') }}"></script>
</body>
</html>