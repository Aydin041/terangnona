@extends('layouts.auth')

@section('title', 'Login Peserta')

@section('content')
    @include('auth._form-login', [
        'judul' => 'Login Peserta',
        'subjudul' => 'Masuk sebagai peserta',
        'action' => route('peserta.login.submit'),
        'daftar' => route('peserta.register'),
    ])
@endsection