@extends('layouts.juri')

@section('title', 'Penilaian Presentasi')

@section('content')
    @include('juri.penilaian._daftar-status', [
        'judul' => 'Penilaian Presentasi (Lolos 5 Besar)',
        'kosongTeks' => 'Belum ada pengajuan yang lolos 5 besar untuk dinilai presentasinya.',
        'rutaDetail' => 'juri.penilaian.presentasi',
    ])
@endsection