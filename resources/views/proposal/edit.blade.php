@extends('layouts.app')

@section('title', 'Ubah Proposal')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1>Ubah Proposal</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('proposal.index') }}">Proposal</a></li>
                <li class="breadcrumb-item active">Ubah</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <p>Mengubah data proposal</p>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">Form Proposal</div>
                <div class="card-body">
                    <form action="{{ route('proposal.update', $proposal) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')

                        @include('proposal.partials.form')

                        <div class="d-flex justify-content-end">
                            <x-adminlte-button type="submit" label="Simpan" theme="warning" icon="fas fa-save"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('proposal.index') }}" class="btn btn-secondary my-2">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
@stop
