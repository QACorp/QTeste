@php
    use App\Modules\Projetos\Enums\PermissionEnum;
@endphp
@extends('adminlte::page')

@section('title', 'QTeste - Aplicações | Projetos | Planos de teste')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)
@section('content_header')
    <div class="row">
        <h1 class="m-0 text-dark col-md-6">Planos de teste de <strong>{{ $projeto->nome }}</strong></h1>
        <div class="text-right col-md-6">
            @can(PermissionEnum::INSERIR_PLANO_TESTE->value)
                <a class="btn btn-primary"
                   href="{{route('aplicacoes.projetos.planos-teste.inserir',[$idAplicacao, $idProjeto])}}"><i
                        class="fas fa-plus"></i> Inserir plano de teste</a>
            @endcan
            @can(PermissionEnum::LISTAR_PROJETO->value)
                <a class="btn btn-warning" href="{{route('aplicacoes.projetos.index',$idAplicacao)}}"><i
                        class="fas fa-undo"></i> Lista de projetos</a>
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
                        id="planos_teste"
                        :heads="$heads"
                        :config="$config"
                        compressed
                        hoverable
                        bordered
                        striped>
                        @foreach($planos_teste as $plano_teste)
                            <tr>
                                <td>{{ $plano_teste->id }}</td>
                                <td>{{ $plano_teste->titulo }}</td>
                                <td>{{ $plano_teste->created_at->format('d/m/Y') }}</td>
                                <td>

                                    <a class="btn btn-primary btn-sm" title="Visualizar"
                                       href="{{ route('aplicacoes.projetos.planos-teste.visualizar',[$idAplicacao, $idProjeto, $plano_teste->id]) }}"><i
                                            class="fas fa-eye"></i> </a>
                                    @can(PermissionEnum::REMOVER_PLANO_TESTE->value)
                                        <x-delete-modal
                                            :registro="$plano_teste"
                                            message="Deseja excluir o registro {{ $plano_teste->titulo }}?"
                                            route="{{ route('aplicacoes.projetos.planos-teste.excluir', [$idAplicacao, $idProjeto, $plano_teste->id]) }}"
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
