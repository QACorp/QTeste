@php
    use App\Modules\GestaoEquipe\Alocacao\Enums\PermissionEnum;
    use App\Modules\GestaoEquipe\Checkpoint\Enums\PermissionEnum as CheckpointPermissionEnum;
@endphp
@extends('adminlte::page')

@section('title', 'QTeste - Alocações')

@section('content_header')
    <div class="row">
        <h1 class="m-0 text-dark col-md-8">Dashboard</h1>

    </div>
@stop

@section('content')
    <div class="row">

        <div class="row">
            <div class="card">
                <div class="card-body">
                    <lista-observacao-checkpoint id-usuario="{{$idUsuario}}" />
                </div>
            </div>
        </div>
    </div>
@stop
