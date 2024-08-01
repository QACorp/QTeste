@php
    use App\Modules\Retrabalhos\Enums\PermissionEnum;
    use App\System\Enums\AuthEnum;
@endphp
@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)
@section('title', 'QTeste - Alocações')

@section('content_header')
    <div class="row">
        <h1 class="m-0 text-dark col-md-8">Alocações</h1>
        <div class="text-right col-md-4">
            @can(PermissionEnum::INSERIR_RETRABALHO->value)
                <a title="Inserir Retrabalho" class="btn btn-primary"
                   href="{{route('retrabalhos.inserir')}}"><i class="fas fa-plus"></i> Inserir alocação</a>
            @endcan
        </div>
    </div>
@stop

@section('content')
    <div class="row" id="vue">
        <div class="row">
            <lista-alocacao-todos
                token-api="{{ session()->get(AuthEnum::SESSION_API_TOKEN->value) }}">

            </lista-alocacao-todos>
        </div>
    </div>
@stop
