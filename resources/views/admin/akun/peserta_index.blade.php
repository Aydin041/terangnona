@extends('layouts.admin')

@section('title', 'Kelola Akun Peserta')

@section('content')
    @include('admin.akun._daftar', [
        'kunci' => 'peserta',
        'peran' => 'Peserta',
        'daftar' => $daftarPeserta,
        'bolehTambah' => false,
        'catatan' => 'Peserta mendaftar sendiri lewat halaman registrasi. Admin dapat mereset password dan menghapus akun. Menghapus akun peserta ikut menghapus semua pengajuannya beserta nilai juri dan dokumennya, secara permanen.',
        'tampilKontak' => true,
    ])
@endsection