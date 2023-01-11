@extends('layouts.app')

@section('title', 'Ubah Jadwal Pendaftaran')

@section('content_header')
    <h1>Ubah Jadwal Pendaftaran</h1>
@stop

@section('content')
    <p>Mengubah data jadwal pendaftaran</p>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">Form Jadwal Pendaftaran</div>
                <div class="card-body">
                    <form action="{{ route('jadwal_pendaftaran.update', $jadwal_pendaftaran) }}" method="post">
                        @csrf
                        @method('put')

                        @include('jadwal_pendaftaran.partials.form')

                        <div class="d-flex justify-content-end">
                            <x-adminlte-button type="submit" label="Simpan" theme="warning" icon="fas fa-save"/>
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
