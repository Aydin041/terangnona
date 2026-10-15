@extends('layouts.auth')

@section('title', 'Login Pimpinan')

@section('content')
    @include('auth._form-login', [
        'judul' => 'Login Pimpinan',
        'subjudul' => 'Masuk sebagai Pimpinan',
        'action' => route('pimpinan.login.submit'),
    ])
@endsection