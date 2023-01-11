@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content_header')
    <h1>Ubah Profil</h1>
@stop

@php($user = auth()->user())

@section('content')
    <p>Mengubah pengaturan profil akun.</p>

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">Informasi Profil</div>
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="post">
                        @csrf
                        @method('put')

                        @include('profile.partials.profile_form')

                        <div class="d-flex justify-content-end">
                            <x-adminlte-button type="submit" label="Ubah" theme="warning" icon="far fa-edit"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    Ganti Password
                </div>
                <div class="card-body">
                    <form action="{{ route('password.update') }}" method="post">
                        @csrf
                        @method('put')

                        @include('profile.partials.password_form')

                        <div class="d-flex justify-content-end">
                            <x-adminlte-button type="submit" label="Ubah" theme="warning" icon="far fa-edit"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
