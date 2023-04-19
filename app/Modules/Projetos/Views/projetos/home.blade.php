@extends('adminlte::page')

@section('title', 'QAKit - Projetos')

@section('content_header')
    <h1 class="m-0 text-dark">Projetos <a title="Inserir projeto" class="btn btn-primary" href="{{route('aplicacoes.projetos.inserir', $idAplicacao)}}"><i class="fas fa-plus"></i> </a></h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <x-adminlte-datatable
                        id="table1"
                        :heads="$heads"
                        :config="$config"
                        compressed
                        hoverable
                        bordered
                        striped>
                        @forelse($projetos as $projeto)
                            <tr>
                                <td>{{ $projeto->id }}</td>
                                <td>{{ $projeto->nome }}</td>
                                <td>{{ $projeto->descricao }}</td>
                                <td>
                                    <a class="btn btn-warning btn-sm" title="Editar" href="{{ route('aplicacoes.projetos.editar',[$projeto->aplicacao_id ,$projeto->id]) }}"><i class="fas fa-edit"></i> </a>
                                    <x-delete-modal
                                        :registro="$projeto"
                                        message="Deseja excluir o registro {{ $projeto->nome }}?"
                                        route="{{ route('aplicacoes.projetos.excluir', [ $projeto->aplicacao_id , $projeto->id]) }}"
                                    />

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">Nenhum registro encontrado</td>
                            </tr>
                        @endforelse
                    </x-adminlte-datatable>
                </div>
            </div>
        </div>
    </div>
@stop
