@extends('layouts.admin')

@section('title', 'Tambah Akun Panitia')

@section('content')
    @include('admin.akun._form-buat', ['kunci' => 'panitia', 'peran' => 'Panitia'])
@endsection