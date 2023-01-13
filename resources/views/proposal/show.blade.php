@extends('layouts.app')

@section('title', 'Detail Proposal')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1>Detail Proposal</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('proposal.index') }}">Proposal</a></li>
                <li class="breadcrumb-item active">Detail</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <p>Melihat data proposal</p>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">Data Proposal</div>
                <div class="card-body p-0">
                    @include('proposal.partials.proposal_readonly')
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('proposal.index') }}" class="btn btn-secondary my-2">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
@stop
