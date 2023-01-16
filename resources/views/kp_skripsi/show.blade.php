@extends('layouts.app')

@section('title', 'Detail Kerja Praktek & Skripsi')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1>Detail Kerja Praktek & Skripsi</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('kp_skripsi.index') }}">Kerja Praktek & Skripsi</a></li>
                <li class="breadcrumb-item active">Detail</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <p>Melihat data kerja praktek & skripsi</p>

    <div class="row">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header">Data Proposal</div>
                <div class="card-body p-0">
                    @include('proposal.partials.readonly', ['proposal' => $kp_skripsi->proposal])
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header">Data Pengajuan</div>
                <div class="card-body p-0">
                    @include('pengajuan.partials.readonly', ['pengajuan' => $kp_skripsi->pengajuan])
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header">Data Persetujuan</div>
                <div class="card-body p-0">
                    @include('pengajuan.persetujuan.partials.readonly', ['persetujuan' => $kp_skripsi->pengajuan->persetujuan])
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('kp_skripsi.index') }}" class="btn btn-secondary my-2">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
@stop
