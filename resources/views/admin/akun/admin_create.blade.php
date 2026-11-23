@extends('layouts.admin')

@section('title', 'Tambah Akun Administrator')

@section('content')
    @include('admin.akun._form-buat', [
        'kunci' => 'admin',
        'peran' => 'Administrator',
    ])
@endsection
