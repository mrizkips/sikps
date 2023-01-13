@extends('layouts.app')

@section('title', 'Ajukan Proposal')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1>Ajukan Proposal</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('proposal.index') }}">Proposal</a></li>
                <li class="breadcrumb-item active">Ajukan</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <p>Mengajukan data proposal</p>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">Form Pengajuan Proposal</div>
                <div class="card-body">
                    <form action="{{ route('pengajuan.store') }}" method="post">
                        @csrf

                        <input type="hidden" name="proposal_id" value="{{ $proposal->id }}">

                        <x-adminlte-select
                            label="Jadwal Pendaftaran*"
                            name="jadwal_pendaftaran_id"
                            >
                            <option disabled selected>Pilih Jadwal Pendaftaran</option>
                            @foreach ($jadwal_pendaftaran as $item)
                                <option value="{{ $item->id }}">{{ $item->judul }}</option>
                            @endforeach
                        </x-adminlte-select>

                        <div class="d-flex justify-content-end">
                            <x-adminlte-button type="submit" label="Ajukan" theme="success" icon="fas fa-paper-plane"/>
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
