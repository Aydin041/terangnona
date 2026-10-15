@extends('layouts.auth')

@section('title', 'Login Admin')

@section('content')
    @include('auth._form-login', [
        'judul' => 'Login Admin',
        'subjudul' => 'Masuk sebagai Admin',
        'action' => route('admin.login.submit'),
    ])
@endsection