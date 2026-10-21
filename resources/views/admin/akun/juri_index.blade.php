@extends('layouts.admin')

@section('title', 'Kelola Akun Juri')

@section('content')
    @include('admin.akun._daftar', [
        'kunci' => 'juri',
        'peran' => 'Juri',
        'daftar' => $daftarJuri,
        'bolehTambah' => true,
    ])
@endsection