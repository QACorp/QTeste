@extends('adminlte::page')

@section('title', 'QAKit - Aplicações | Projetos | Alterar')
@section('plugins.Datatables', true)
@section('content_header')
    <h1 class="m-0 text-dark">Alterar Projeto </h1>

@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                        <div class="row">
                            <div class="col-md-6">
                                <form method="post" action="{{ route('aplicacoes.projetos.atualizar',[$projeto->aplicacao_id , $projeto->id]) }}">
                                    @csrf
                                    @method('put')
                                    <div class="row">
                                        <div class="col-md-12">
                                            <x-adminlte-input
                                                name="nome"
                                                label="Nome"
                                                placeholder="Nome"
                                                fgroup-class="col-md-12"
                                                value="{{ old('nome',$projeto->nome) }}"
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
                                                value="{{ old('inicio',$projeto->inicio->format('Y-m-d')) }}"
                                            />
                                        </div>
                                        <div class="col-md-6">
                                            <x-adminlte-input
                                                name="termino"
                                                label="Término"
                                                placeholder="Data de término"
                                                type="date"
                                                fgroup-class="col-md-12"
                                                value="{{ old('termino',$projeto->termino->format('Y-m-d')) }}"
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
                                                {{ old('descricao',$projeto->descricao) }}
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
                                        <a href="{{ route('aplicacoes.projetos.index', $projeto->aplicacao_id) }}"
                                           class="btn btn-primary ml-1"
                                        ><i class="fas fa-undo"></i> Voltar para lista</a>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-12">
                                        <h4>Atividades recente</h4>
                                        <form method="post" action="{{ route('aplicacoes.projetos.observacao.salvar', [$projeto->aplicacao_id ,$projeto->id]) }}">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <x-adminlte-textarea
                                                        name="observacao[descricao]"
                                                        label="Observação"
                                                        rows=5
                                                        igroup-size="sm"
                                                        placeholder="Adicionar observação"
                                                    >
                                                        <x-slot name="prependSlot">
                                                            <div class="input-group-text">
                                                                <i class="fas fa-lg fa-comment-dots text-dark"></i>
                                                            </div>
                                                        </x-slot>
                                                        <x-slot name="appendSlot">
                                                            <x-adminlte-button theme="dark" type="submit" icon="fas fa-paper-plane" label="Adicionar"/>
                                                        </x-slot>
                                                        {{ old('observacao.descricao','') }}
                                                    </x-adminlte-textarea>
                                                </div>
                                            </div>
                                        </form>
                                    @forelse($observacoes as $observacao)

                                        <div class="post">
                                            <div class="user-block">
                                                <img class="img-circle img-bordered-sm" src="../../dist/img/user1-128x128.jpg" alt="user image">
                                                <span class="username">
                                                    <a href="#">{{ $observacao->user->name }}</a>
                                                </span>
                                                <span class="description">{{ $observacao->created_at->format('d/m/Y H\hi') }}</span>
                                            </div>

                                            <p>
                                                {{ $observacao->descricao }}
                                            </p>
                                            {{--<p>
                                                <a href="#" class="link-black text-sm"><i class="fas fa-link mr-1"></i> Demo File 1 v2</a>
                                            </p>--}}
                                        </div>

                                    @empty
                                        <div>Não há observacao</div>
                                    @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
