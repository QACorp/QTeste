@extends('adminlte::page')

@section('title', 'QTeste - Aplicações | Projetos | Planos de teste | Inserir')
@section('content_header')
    <h1 class="m-0 text-dark">Inserir Plano de Teste </h1>

@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('aplicacoes.projetos.planos-teste.salvar', [$idAplicacao, $idProjeto]) }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-9">
                                <div class="row">
                                    <x-adminlte-input
                                        label="Título"
                                        name="titulo"
                                        placeholder="titulo"
                                        fgroup-class="col-md-6"
                                        value="{{ old('titulo','') }}"
                                    />
                                </div>
                                <div class="row">
                                    <x-adminlte-textarea
                                        label="Descrição"
                                        name="descricao"
                                        placeholder="Inserir uma descrição"
                                        fgroup-class="col-md-6"
                                    >
                                    {{ old('descricao','') }}
                                    </x-adminlte-textarea>
                                </div>
                                <div class="row p-2">
                                    <x-adminlte-button
                                        label="Salvar"
                                        theme="success"
                                        icon="fas fa-save"
                                        type="submit"
                                    />
                                    <a href="{{ route('aplicacoes.projetos.planos-teste.index',[$idAplicacao, $idProjeto]) }}"
                                       class="btn btn-primary ml-1"
                                    ><i class="fas fa-undo"></i> Cancelar</a>
                                </div>
                            </div>
                            <div class="col-md-3">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
