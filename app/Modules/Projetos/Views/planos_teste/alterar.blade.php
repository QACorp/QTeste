@extends('adminlte::page')

@section('title', 'QAKit - Aplicações | Projetos | Planos de Teste | Visualizar')
@section('plugins.Datatables', true)
@section('plugins.JqueryUi', true)
@section('content_header')
    <h1 class="m-0 text-dark">Visualizar Plano de teste <strong>{{ $planoTeste->titulo }}</strong></h1>

@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            Dados do plano de teste
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <form method="post" action="{{ route('aplicacoes.projetos.planos-teste.alterar',[$idAplicacao, $idProjeto, $idPlanoTeste]) }}">
                                        @csrf
                                        @method('put')
                                        <div class="row">
                                            <div class="col-md-12">
                                                <x-adminlte-input
                                                    name="titulo"
                                                    label="Título"
                                                    placeholder="Título"
                                                    fgroup-class="col-md-12"
                                                    value="{{ old('titulo',$planoTeste->titulo) }}"
                                                />
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <x-adminlte-textarea
                                                    label="Descrição"
                                                    name="descricao"
                                                    placeholder="Inserir uma descrição"
                                                    fgroup-class="col-md-12"
                                                >
                                                    {{ old('descricao',$planoTeste->descricao) }}
                                                </x-adminlte-textarea>
                                            </div>
                                        </div>
                                        <div class="row pl-3">
                                            <x-adminlte-button
                                                label="Salvar"
                                                theme="success"
                                                icon="fas fa-save"
                                                type="submit"
                                            />
                                            <a href="{{ route('aplicacoes.projetos.planos-teste.index', [$idAplicacao, $idProjeto]) }}"
                                               class="btn btn-primary ml-1"
                                            ><i class="fas fa-undo"></i> Voltar para lista</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            Casos de teste
                        </div>
                        <div class="card-body">
                            @include('projetos::planos_teste.casos_teste_lista')
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>

@stop
