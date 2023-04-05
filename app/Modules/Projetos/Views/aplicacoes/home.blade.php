@extends('adminlte::page')

@section('title', 'QAKit - Aplicações')
@section('plugins.Datatables', true)
@section('content_header')
    <h1 class="m-0 text-dark">Aplicações   <a class="btn btn-primary" href="{{route('aplicacoes.inserir')}}"><i class="fas fa-plus"></i> </a></h1>

@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <x-adminlte-datatable
                        id="table2"
                        :heads="$heads"
                        :config="$config"
                        head-theme="dark"
                        striped hoverable bordered compressed
                    />
                </div>
            </div>
        </div>
    </div>
@stop
