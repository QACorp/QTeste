@extends('adminlte::page')

@section('title', 'QAKit - Projetos')

@section('content_header')
    <h1 class="m-0 text-dark">Projetos</h1>
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
                        @foreach($projetos as $projeto)
                            <tr>
                                <td>{{ $projeto->id }}</td>
                                <td>{{ $projeto->nome }}</td>
                                <td>{{ $projeto->descricao }}</td>
                                <td>
                                    <a class="btn btn-warning btn-sm" title="Editar" href="{{ route('aplicacoes.editar',$projeto->id) }}"><i class="fas fa-edit"></i> </a>
                                    <x-delete-modal
                                        :registro="$projeto"
                                        message="Deseja excluir o registro {{ $projeto->nome }}?"
                                        route="{{ route('aplicacoes.excluir', $projeto->id) }}"
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
