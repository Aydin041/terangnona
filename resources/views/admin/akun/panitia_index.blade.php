@extends('layouts.admin')

@section('title', 'Kelola Akun Panitia')

@section('content')
    @include('admin.akun._daftar', [
        'kunci' => 'panitia',
        'peran' => 'Panitia',
        'daftar' => $daftarPanitia,
        'bolehTambah' => true,
    ])
@endsection