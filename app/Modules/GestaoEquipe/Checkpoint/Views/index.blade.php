@php
    use App\Modules\GestaoEquipe\Checkpoint\Enums\PermissionEnum;
@endphp
@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)
@section('title', 'QTeste - Alocações')

@section('content_header')
    <div class="row">
        <h1 class="m-0 text-dark col-md-8">Equipe</h1>

    </div>
@stop

@section('content')
    <div class="row">

        <div class="row">
            <div class="card">
                <div class="card-body">
                    <lista-usuarios />
                </div>
            </div>
        </div>
    </div>
@stop
