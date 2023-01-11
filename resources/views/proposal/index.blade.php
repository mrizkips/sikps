@extends('layouts.app')

@section('title', 'Proposal')

@section('content_header')
    <h1>Proposal</h1>
@stop

@section('content')
    <p>Mengelola data proposal.</p>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span class="mr-auto">Data Proposal</span>
            @can('create', App\Models\Proposal::class)
            <a href="{{ route('proposal.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Data
            </a>
            @endcan
        </div>
        <div class="card-body">
            <section>

            </section>
        </div>
    </div>
@stop
