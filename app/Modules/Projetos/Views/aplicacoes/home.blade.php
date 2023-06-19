@extends('adminlte::page')

@section('title', 'QAKit - Aplicações')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)
@section('content_header')
    <h1 class="m-0 text-dark">Aplicações
        @can(\App\Modules\Projetos\Enums\PermissionEnum::INSERIR_APLICACAO->value)
            <a class="btn btn-primary" href="{{route('aplicacoes.inserir')}}"><i class="fas fa-plus"></i> </a>
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
                        @foreach($aplicacoes as $aplicacao)
                            <tr>
                                <td>{{ $aplicacao->id }}</td>
                                <td>{{ $aplicacao->nome }}</td>
                                <td>{{ $aplicacao->descricao }}</td>
                                <td>
                                    @can(\App\Modules\Projetos\Enums\PermissionEnum::LISTAR_PROJETO->value)
                                        <a class="btn btn-dark btn-sm" title="Acessar projetos"
                                           href="{{ route('aplicacoes.projetos.index',$aplicacao->id) }}"><i
                                                class="fas fa-cogs"></i> </a>
                                    @endcan
                                    @can(\App\Modules\Projetos\Enums\PermissionEnum::ALTERAR_APLICACAO->value)
                                        <a class="btn btn-warning btn-sm" title="Editar"
                                           href="{{ route('aplicacoes.editar',$aplicacao->id) }}"><i
                                                class="fas fa-edit"></i> </a>
                                    @endcan
                                    @can(\App\Modules\Projetos\Enums\PermissionEnum::REMOVER_APLICACAO->value)
                                        <x-delete-modal
                                            :registro="$aplicacao"
                                            message="Deseja excluir o registro {{ $aplicacao->nome }}?"
                                            route="{{ route('aplicacoes.excluir', $aplicacao->id) }}"
                                        />
                                    @endcan

                                </td>
                            </tr>
                        @endforeach
                    </x-adminlte-datatable>
                </div>
            </div>
        </div>
    </div>
@stop
