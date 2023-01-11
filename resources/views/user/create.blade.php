@extends('layouts.app')

@section('title', 'Tambah Pengguna')

@section('content_header')
    <h1>Tambah Pengguna</h1>
@stop

@section('content')
    <p>Menambahkan data pengguna</p>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">Form Pengguna</div>
                <div class="card-body">
                    <form action="{{ route('users.store') }}" method="post">
                        @csrf

                        @include('user.partials.form')

                        <div class="d-flex justify-content-end">
                            <x-adminlte-button type="submit" label="Simpan" theme="success" icon="fas fa-save"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('users.index') }}" class="btn btn-secondary my-2">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
@stop
