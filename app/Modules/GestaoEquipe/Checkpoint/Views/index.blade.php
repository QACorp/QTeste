@php
    use App\Modules\GestaoEquipe\Alocacao\Enums\PermissionEnum;
    use App\System\Enums\AuthEnum;
@endphp
@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)
@section('title', 'QTeste - Alocações')

@section('content_header')
    <div class="row">
        <h1 class="m-0 text-dark col-md-8">Checkpoints</h1>

    </div>
@stop

@section('content')
    <div class="row" id="vue">

        <div class="row">
            <div class="card">
                <div class="card-body">
                    @can(\App\Modules\GestaoEquipe\Checkpoint\Enums\PermissionEnum::VER_CHECKPOINT->value)
                        <lista-usuarios  />
                    @else
                        <div class="alert alert-danger" role="alert">
                            Você não tem permissão para acessar essa página.
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@stop
