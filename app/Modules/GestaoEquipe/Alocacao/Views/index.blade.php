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
        <h1 class="m-0 text-dark col-md-8">Alocações</h1>

    </div>
@stop

@section('content')
    <div class="row" id="vue">

        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="text-right col-md-12 col-12 mb-5">
                            @can(PermissionEnum::CRIAR_ALOCACAO->value)
                                <modal-insert-alocacao></modal-insert-alocacao>
                            @endcan
                        </div>
                    </div>
                    @if(Auth::guard('web')->user()->can(PermissionEnum::VER_ALOCACAO->value))
                    <lista-alocacao-todos
                        :edit-alocacao="{{ Auth::guard('web')->user()->can(PermissionEnum::EDITAR_ALOCACAO->value) == true ? 'true' : 'false' }}"
                        :finish-alocacao="{{ Auth::guard('web')->user()->can(PermissionEnum::CONCLUIR_ALOCACAO->value) == true ? 'true' : 'false' }}"
                    >
                    </lista-alocacao-todos>
                    @elseif(Auth::guard('web')->user()->can(PermissionEnum::VER_MINHA_ALOCACAO->value))
                        <lista-alocacao-meus
                            :edit-alocacao="{{ Auth::guard('web')->user()->can(PermissionEnum::EDITAR_ALOCACAO->value) == true ? 'true' : 'false' }}"
                            :finish-alocacao="{{ Auth::guard('web')->user()->can(PermissionEnum::CONCLUIR_ALOCACAO->value) == true ? 'true' : 'false' }}"
                        >
                        </lista-alocacao-meus>
                        @endif
                </div>
            </div>
        </div>
    </div>
@stop
