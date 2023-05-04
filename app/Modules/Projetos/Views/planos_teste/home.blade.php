@extends('adminlte::page')

@section('title', 'QAKit - Aplicações | Projetos | Planos de teste')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)
@section('content_header')
    <h1 class="m-0 text-dark">Planos de teste   <a class="btn btn-primary" href="{{route('aplicacoes.projetos.planos-teste.inserir',[$idAplicacao, $idProjeto])}}"><i class="fas fa-plus"></i> </a></h1>

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
                                <td>{{ $plano_teste->created_at }}</td>
                                <td>
                                    <a class="btn btn-dark btn-sm" title="Acessar projetos" href="{{ route('aplicacoes.projetos.index',$plano_teste->id) }}"><i class="fas fa-cogs"></i> </a>

                                    <a class="btn btn-warning btn-sm" title="Editar" href="{{ route('aplicacoes.editar',$plano_teste->id) }}"><i class="fas fa-edit"></i> </a>
                                    <x-delete-modal
                                        :registro="$plano_teste"
                                        message="Deseja excluir o registro {{ $plano_teste->titulo }}?"
                                        route="{{ route('aplicacoes.projetos.planos-teste.excluir', [$idAplicacao, $idProjeto, $plano_teste->id]) }}"
                                    />

                                </td>
                            </tr>
                        @endforeach
                    </x-adminlte-datatable>
                </div>
            </div>
        </div>
    </div>
@stop
