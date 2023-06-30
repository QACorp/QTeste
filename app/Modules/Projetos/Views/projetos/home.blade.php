@extends('adminlte::page')

@section('title', 'QAKit - Projetos')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)
@section('content_header')
    <h1 class="m-0 text-dark">Projetos
        @can(\App\Modules\Projetos\Enums\PermissionEnum::INSERIR_PROJETO->value)
            <a title="Inserir projeto" class="btn btn-primary"
               href="{{route('aplicacoes.projetos.inserir', $idAplicacao)}}"><i class="fas fa-plus"></i> </a>
        @endcan
    </h1>
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
                                    @can(\App\Modules\Projetos\Enums\PermissionEnum::ALTERAR_APLICACAO->value)
                                        <a class="btn btn-warning btn-sm" title="Editar"
                                           href="{{ route('aplicacoes.projetos.editar',[$projeto->aplicacao_id ,$projeto->id]) }}"><i
                                                class="fas fa-edit"></i> </a>
                                    @endcan
                                    @can(\App\Modules\Projetos\Enums\PermissionEnum::LISTAR_PLANO_TESTE->value)
                                        <a class="btn btn-primary btn-sm" title="Planos de teste"
                                           href="{{ route('aplicacoes.projetos.planos-teste.index',[$projeto->aplicacao_id ,$projeto->id]) }}"><i
                                                class="fas fa-file-alt"></i> </a>
                                    @endcan
                                    @can(\App\Modules\Projetos\Enums\PermissionEnum::REMOVER_PROJETO->value)
                                        <x-delete-modal
                                            :registro="$projeto"
                                            message="Deseja excluir o registro {{ $projeto->nome }}?"
                                            route="{{ route('aplicacoes.projetos.excluir', [ $projeto->aplicacao_id , $projeto->id]) }}"
                                        />
                                    @endcan

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
