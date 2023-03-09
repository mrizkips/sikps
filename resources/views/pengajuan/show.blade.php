@extends('layouts.app')

@section('title', 'Detail Pengajuan')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1>Detail Pengajuan</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('pengajuan.index') }}">Pengajuan</a></li>
                <li class="breadcrumb-item active">Detail</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <p>Melihat data pengajuan</p>

    <div class="row">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header">Data Proposal</div>
                <div class="card-body p-0">
                    @include('proposal.partials.readonly', ['proposal' => $pengajuan->proposal])
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header">Data Pengajuan</div>
                <div class="card-body p-0">
                    @include('pengajuan.partials.readonly')
                </div>
            </div>
            <div class="card">
                <div class="card-header">Data Persetujuan</div>
                <div class="card-body p-0">
                    @include('pengajuan.persetujuan.partials.readonly', ['persetujuan' => $pengajuan->persetujuan])
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('pengajuan.index') }}" class="btn btn-secondary my-2">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
@stop
