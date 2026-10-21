@extends('layouts.admin')

@section('title', 'Kelola Akun Peserta')

@section('content')
    @include('admin.akun._daftar', [
        'kunci' => 'peserta',
        'peran' => 'Peserta',
        'daftar' => $daftarPeserta,
        'bolehTambah' => false,
        'catatan' => 'Peserta mendaftar sendiri lewat halaman registrasi. Di sini Admin hanya bisa mereset password dan menghapus akun yang belum punya pengajuan (misalnya akun spam atau salah daftar).',
        'tampilKontak' => true,
    ])
@endsection