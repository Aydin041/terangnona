@extends('layouts.admin')

@section('title', 'Tambah Akun Pimpinan')

@section('content')
    @include('admin.akun._form-buat', ['kunci' => 'pimpinan', 'peran' => 'Pimpinan'])
@endsection