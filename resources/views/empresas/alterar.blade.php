@extends('adminlte::page')
@section('plugins.Select2', true)
@section('title', 'QTeste - Empresa | Alterar dados')
@section('content_header')
    <h1 class="m-0 text-dark">Alterar dados da empresa </h1>

@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('users.atualizar-empresa') }}">
                        @csrf
                        @method('put')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <x-adminlte-input
                                        name="nome"
                                        label="Nome"
                                        placeholder="Nome"
                                        fgroup-class="col-md-12"
                                        value="{{ old('nome',$empresa->nome) }}"
                                        required
                                    />
                                </div>

                                <div class="row p-2">
                                    <x-adminlte-button
                                        label="Salvar"
                                        theme="success"
                                        icon="fas fa-save"
                                        type="submit"
                                    />
                                    <a href="{{ route('home') }}"
                                       class="btn btn-primary ml-1"
                                    ><i class="fas fa-undo"></i> Cancelar</a>
                                </div>
                            </div>
                            <div class="col-md-6 border-2 border-left pl-4">
                                <h3>Administradores da empresa</h3>
                                <div class="row">
                                    <x-adminlte-datatable
                                        id="administradores"
                                        :heads="$heads"
                                        :config="$config"
                                        compressed
                                        hoverable
                                        bordered
                                        striped>
                                        @foreach($administradores as $administrador)
                                            <tr>
                                                <td>{{ $administrador->id }}</td>
                                                <td>{{ $administrador->name }}</td>
                                                <td>{{ $administrador->email }}</td>
                                            </tr>
                                        @endforeach
                                    </x-adminlte-datatable>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

