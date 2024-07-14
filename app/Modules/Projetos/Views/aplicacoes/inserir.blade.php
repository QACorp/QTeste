@extends('adminlte::page')

@section('title', 'QTeste - Aplicações | Inserir')
@section('plugins.Datatables', true)
@section('content_header')
    <h1 class="m-0 text-dark">Inserir Aplicação </h1>

@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('aplicacoes.salvar') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <x-adminlte-input
                                        label="Nome"
                                        name="nome"
                                        placeholder="Nome"
                                        fgroup-class="col-md-12"
                                        value="{{ old('nome','') }}"
                                    />
                                </div>
                                <div class="row">
                                    <x-adminlte-textarea
                                        label="Descrição"
                                        name="descricao"
                                        placeholder="Inserir uma descrição"
                                        fgroup-class="col-md-12"
                                    >
                                    {{ old('descricao','') }}
                                    </x-adminlte-textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
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
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <x-combo-equipes
                                        :idsEquipe="old('equipes',[])"
                                    >
                                    </x-combo-equipes>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
