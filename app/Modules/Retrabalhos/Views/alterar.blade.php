@php
    use App\Modules\Retrabalhos\Enums\CriticidadeEnum;
@endphp
@extends('adminlte::page')

@section('title', 'QTeste - Retrabalhos | Alterar')
@section('plugins.Datatables', true)
@section('content_header')
    <h1 class="m-0 text-dark">
        <a href="{{ route('retrabalhos.index') }}" class="btn btn-warning rounded-circle mr-1" title="Voltar para a lista">
            <i class="fas fa-arrow-left"></i>
        </a>
        Alterar retrabalho
    </h1>

@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <form-inserir-retrabalho
                       id-retrabalho="{{ $retrabalho->id }}" ></form-inserir-retrabalho>

                </div>
            </div>
        </div>
    </div>
@stop
