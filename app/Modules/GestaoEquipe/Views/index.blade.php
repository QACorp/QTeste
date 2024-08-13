@php
    use App\Modules\GestaoEquipe\Enums\PermissionEnum;
    use App\System\Enums\AuthEnum;
@endphp
@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)
@section('title', 'QTeste - Alocações')

@section('content_header')
    <div class="row">
        <h1 class="m-0 text-dark col-md-8">Alocações</h1>

    </div>
@stop

@section('content')
    <div class="row" id="vue">

        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="text-right col-md-12 col-12 mb-2">
                            @can(PermissionEnum::CRIAR_ALOCACAO->value)
                                <modal-insert-alocacao></modal-insert-alocacao>
                            @endcan
                        </div>
                    </div>
                    <lista-alocacao-todos
                        token-api="{{ session()->get(AuthEnum::SESSION_API_TOKEN->value) }}">

                    </lista-alocacao-todos>
                </div>
            </div>
        </div>
    </div>
@stop
