@extends('layouts.app')

@section('title', 'Pengguna')

@section('content_header')
    <h1>Pengguna</h1>
@stop

@section('content')
    <p>Mengelola data pengguna.</p>

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="mr-auto">Kontrol Data</span>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.importDosen') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <x-adminlte-input-file
                            name="file"
                            placeholder="Pilih file xls, xlsx, atau csv..."
                            legend="Unggah"
                            onchange="form.submit()"
                            label="Import Data Dosen"
                            >
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-lightblue">
                                    <i class="fas fa-upload"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input-file>

                    </form>
                    <form action="{{ route('users.importMahasiswa') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <x-adminlte-input-file
                            name="file"
                            placeholder="Pilih file xls, xlsx, atau csv..."
                            legend="Unggah"
                            onchange="form.submit()"
                            label="Import Data Mahasiswa"
                            >
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-lightblue">
                                    <i class="fas fa-upload"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input-file>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span class="mr-auto">Data pengguna</span>
            @can('create', App\Models\User::class)
            <a href="{{ route('users.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Data
            </a>
            @endcan
        </div>
        <div class="card-body">
            <section>
                @include('user.partials.datatable')
            </section>
        </div>
    </div>
@stop
