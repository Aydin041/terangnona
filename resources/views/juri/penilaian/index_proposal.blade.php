@extends('layouts.juri')

@section('title', 'Penilaian Proposal')

@section('content')
    @include('juri.penilaian._daftar-status', [
        'judul' => 'Penilaian Proposal',
        'kosongTeks' => 'Belum ada pengajuan yang disetujui Panitia untuk dinilai.',
        'rutaDetail' => 'juri.penilaian.proposal',
    ])
@endsection