@php
    use App\Modules\Projetos\Enums\PermissionEnum;
@endphp
@extends('adminlte::page')

@section('title', 'QTeste - Projetos')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)
@section('content_header')
    <div class="row">
        <h1 class="m-0 text-dark col-md-8">Projetos</h1>
        <div class="text-right col-md-4">
            @can(PermissionEnum::INSERIR_PROJETO->value)
                <a title="Inserir projeto" class="btn btn-primary"
                   href="{{route('aplicacoes.projetos.inserir', $idAplicacao)}}"><i class="fas fa-plus"></i> Inserir
                    projeto</a>
            @endcan
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <x-adminlte-datatable
                        id="projetos"
                        :heads="$heads"
                        :config="$config"
                        compressed
                        hoverable
                        bordered
                        striped>
                        @foreach($projetos as $projeto)
                            <tr>
                                <td>{{ $projeto->id }}</td>
                                <td>{{ $projeto->nome }}</td>
                                <td>{{ $projeto->descricao }}</td>
                                <td>
                                    @can(PermissionEnum::ALTERAR_APLICACAO->value)
                                        <a class="btn btn-warning btn-sm" title="Editar"
                                           href="{{ route('aplicacoes.projetos.editar',[$projeto->aplicacao_id ,$projeto->id]) }}"><i
                                                class="fas fa-edit"></i> </a>
                                    @endcan
                                    @can(PermissionEnum::LISTAR_PLANO_TESTE->value)
                                        <a class="btn btn-primary btn-sm" title="Planos de teste"
                                           href="{{ route('aplicacoes.projetos.planos-teste.index',[$projeto->aplicacao_id ,$projeto->id]) }}"><i
                                                class="fas fa-file-alt"></i> </a>
                                    @endcan
                                    @can(PermissionEnum::REMOVER_PROJETO->value)
                                        <x-delete-modal
                                            :registro="$projeto"
                                            message="Deseja excluir o registro {{ $projeto->nome }}?"
                                            route="{{ route('aplicacoes.projetos.excluir', [ $projeto->aplicacao_id , $projeto->id]) }}"
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
