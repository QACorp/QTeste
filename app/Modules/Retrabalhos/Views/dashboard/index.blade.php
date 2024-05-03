@php
    use App\Modules\Retrabalhos\Enums\PermissionEnum;
@endphp
@extends('adminlte::page')

@section('title', 'QAKit - Dashboard de Retrabalhos')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)
@section('content_header')
    <div class="row">
        <h1 class="m-0 text-dark col-md-8">
            Dashboard de retrabalhos
        </h1>
        <div class="text-right col-md-2">
            <form method="GET" id="select-ano">
                <x-adminlte-select name="ano" onclick="$('#select-ano').submit()">
                    @foreach($anos as $lAno)
                        <option value="{{$lAno}}" @if($lAno == $ano) selected @endif>{{$lAno}}</option>
                    @endforeach
                </x-adminlte-select>
            </form>
        </div>
        <div class="text-right col-md-2">

            @can(PermissionEnum::INSERIR_RETRABALHO->value)
                <a title="Inserir Retrabalho" class="btn btn-primary"
                   href="{{route('retrabalhos.inserir')}}"><i class="fas fa-plus"></i> Inserir retrabalho</a>
            @endcan
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <x-retrabalho-total-equipe :ano="$ano"></x-retrabalho-total-equipe>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <x-grafico-evolucao-retrabalho :ano="$ano"></x-grafico-evolucao-retrabalho>
                                </div>
                                <div class="col-md-6">
                                    <x-grafico-evolucao-retrabalho-aplicacao :ano="$ano"></x-grafico-evolucao-retrabalho-aplicacao>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <x-grafico-evolucao-retrabalho-usuario :ano="$ano"></x-grafico-evolucao-retrabalho-usuario>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
