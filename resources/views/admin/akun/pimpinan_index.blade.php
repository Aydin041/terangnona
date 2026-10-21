@extends('layouts.admin')

@section('title', 'Kelola Akun Pimpinan')

@section('content')
    @include('admin.akun._daftar', [
        'kunci' => 'pimpinan',
        'peran' => 'Pimpinan',
        'daftar' => $daftarPimpinan,
        'bolehTambah' => true,
    ])
@endsection