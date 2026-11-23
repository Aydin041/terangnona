@extends('layouts.admin')

@section('title', 'Kelola Akun Administrator')

@section('content')
    @include('admin.akun._daftar', [
        'kunci' => 'admin',
        'peran' => 'Administrator',
        'daftar' => $daftarAdmin,
        'bolehTambah' => true,
        'catatan' => 'Akun Administrator memiliki hak akses penuh terhadap seluruh konfigurasi, data inovasi, dan manajemen pengguna sistem.',
    ])
@endsection
