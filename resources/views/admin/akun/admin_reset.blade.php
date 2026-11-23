@extends('layouts.admin')

@section('title', 'Reset Password Administrator')

@section('content')
    @include('admin.akun._form-reset', [
        'kunci' => 'admin',
        'peran' => 'Administrator',
        'target' => $admin,
    ])
@endsection
