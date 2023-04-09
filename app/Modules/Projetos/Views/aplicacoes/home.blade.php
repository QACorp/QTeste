@extends('adminlte::page')

@section('title', 'QAKit - Aplicações')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)
@section('content_header')
    <h1 class="m-0 text-dark">Aplicações   <a class="btn btn-primary" href="{{route('aplicacoes.inserir')}}"><i class="fas fa-plus"></i> </a></h1>

@stop

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{--<x-adminlte-datatable
                        id="table2"
                        :heads="$heads"
                        :config="$config"
                        head-theme="dark"
                        striped
                        hoverable
                        bordered
                        compressed
                        with-buttons
                    />--}}
                    <x-adminlte-datatable
                        id="table1"
                        :heads="$heads"
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
                                    <a class="btn btn-warning btn-sm" href="{{ route('aplicacoes.editar',$aplicacao->id) }}"><i class="fas fa-edit"></i> </a>
                                    <x-adminlte-modal id="modalMin_{{ $aplicacao->id }}" title="Minimal"/>
                                    <x-adminlte-button class="btn-sm" theme="danger" label="" icon="fas fa-trash" data-toggle="modal" data-target="#modalMin_{{ $aplicacao->id }}"/>
                                </td>
                            </tr>
                        @endforeach
                    </x-adminlte-datatable>
                </div>
            </div>
        </div>
    </div>
@stop
