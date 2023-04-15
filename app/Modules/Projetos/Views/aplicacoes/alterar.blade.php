@extends('adminlte::page')

@section('title', 'QAKit - Aplicações | Alterar')
@section('plugins.Datatables', true)
@section('content_header')
    <h1 class="m-0 text-dark">Alterar Aplicação </h1>

@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('aplicacoes.atualizar',$aplicacao->id) }}">
                        @csrf
                        @method('put')
                        <div class="row">
                            <div class="col-md-9">
                                <div class="row">
                                    <x-adminlte-input
                                        name="nome"
                                        label="Nome"
                                        placeholder="Nome"
                                        fgroup-class="col-md-6"
                                        value="{{ old('nome',$aplicacao->nome) }}"
                                    />
                                </div>
                                <div class="row">
                                    <x-adminlte-textarea
                                        label="Descrição"
                                        name="descricao"
                                        placeholder="Inserir uma descrição"
                                        fgroup-class="col-md-6"
                                    >
                                        {{ old('descricao',$aplicacao->descricao) }}
                                    </x-adminlte-textarea>
                                </div>
                                <div class="row p-2">
                                    <x-adminlte-button
                                        label="Salvar"
                                        theme="success"
                                        icon="fas fa-save"
                                        type="submit"
                                    />
                                    <a href="{{ route('aplicacoes.index') }}"
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
