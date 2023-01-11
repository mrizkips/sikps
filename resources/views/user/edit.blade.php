@extends('layouts.app')

@section('title', 'Ubah Pengguna')

@section('content_header')
    <h1>Ubah Pengguna</h1>
@stop

@section('content')
    <p>Mengubah data pengguna</p>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">Form Pengguna</div>
                <div class="card-body">
                    <form action="{{ route('users.update', $user) }}" method="post">
                        @csrf
                        @method('put')

                        @include('user.partials.form')

                        <div class="d-flex justify-content-end">
                            <x-adminlte-button type="submit" label="Simpan" theme="warning" icon="fas fa-save"/>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header">Ganti Password</div>
                <div class="card-body">
                    <form action="{{ route('users.update_password', $user) }}" method="post">
                        @csrf
                        @method('put')

                        <x-adminlte-input
                            label="Password*"
                            type="password"
                            name="password"
                            />

                        <x-adminlte-input
                            label="Konfirmasi Password*"
                            type="password"
                            name="password_confirmation"
                            />

                        <div class="d-flex justify-content-end">
                            <x-adminlte-button type="submit" label="Simpan" theme="warning" icon="fas fa-save"/>
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
