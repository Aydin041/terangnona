@extends('layouts.auth')

@section('title', 'Login Panitia')

@section('content')
    @include('auth._form-login', [
        'judul' => 'Login Panitia',
        'subjudul' => 'Masuk sebagai Panitia',
        'action' => route('panitia.login.submit'),
    ])
@endsection