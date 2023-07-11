@extends('adminlte::page')

@section('title', 'QAKit - Aplicações | Projetos | Alterar')
@section('plugins.Datatables', true)
@section('content_header')
    <h1 class="m-0 text-dark">Inserir Projeto </h1>

@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('aplicacoes.projetos.salvar',$idAplicacao) }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <x-adminlte-input
                                            name="nome"
                                            label="Nome"
                                            placeholder="Nome"
                                            fgroup-class="col-md-12"
                                            value="{{ old('nome','') }}"
                                        />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <x-adminlte-input
                                            name="inicio"
                                            label="Início"
                                            placeholder="Data de início"
                                            type="date"
                                            fgroup-class="col-md-12"
                                            value="{{ old('inicio','') }}"
                                        />
                                    </div>
                                    <div class="col-md-6">
                                        <x-adminlte-input
                                            name="termino"
                                            label="Data"
                                            placeholder="Data de término"
                                            type="date"
                                            fgroup-class="col-md-12"
                                            value="{{ old('termino','') }}"
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
                                            {{ old('descricao','') }}
                                        </x-adminlte-textarea>
                                    </div>
                                </div>
                                <div class="row p-2">
                                    <x-adminlte-button
                                        label="Salvar"
                                        theme="success"
                                        icon="fas fa-save"
                                        type="submit"
                                    />
                                    <a href="{{ route('aplicacoes.projetos.index', $idAplicacao) }}"
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
