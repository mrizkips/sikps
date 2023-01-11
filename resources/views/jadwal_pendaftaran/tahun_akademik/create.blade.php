@extends('layouts.app')

@section('title', 'Tambah Tahun Akademik')

@section('content_header')
    <h1>Tambah Tahun Akademik</h1>
@stop

@section('content')
    <p>Menambahkan data tahun akademik</p>

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">Form Tahun Akademik</div>
                <div class="card-body">
                    <form action="{{ route('tahun_akademik.store') }}" method="post">
                        @csrf

                        @include('jadwal_pendaftaran.tahun_akademik.partials.form')

                        <div class="d-flex justify-content-end">
                            <x-adminlte-button type="submit" label="Simpan" theme="success" icon="fas fa-save"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('jadwal_pendaftaran.index') }}" class="btn btn-secondary my-2">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
@stop
