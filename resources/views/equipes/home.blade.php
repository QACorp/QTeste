@extends('adminlte::page')

@section('title', 'QAKit - Equipes')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)
@section('content_header')
    <div class="row">
        <h1 class="m-0 text-dark col-md-8">Equipes</h1>
        <div class="text-right col-md-4">
            @can(\App\System\Enums\PermissionEnum::INSERIR_EQUIPE->value)
                <a class="btn btn-primary" href="{{route('equipes.inserir')}}"><i class="fas fa-plus"></i> Inserir equipe</a>
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
                        id="equipess"
                        :heads="$heads"
                        :config="$config"
                        compressed
                        hoverable
                        bordered
                        striped>
                        @foreach($equipes as $equipe)
                            <tr>
                                <td>{{ $equipe->id }}</td>
                                <td>{{ $equipe->nome }}</td>
                                <td>
                                    @can(\App\System\Enums\PermissionEnum::ALTERAR_EQUIPE->value)
                                        <a class="btn btn-warning btn-sm" title="Editar"
                                           href="{{ route('equipes.editar',$equipe->id) }}"><i class="fas fa-edit"></i> </a>
                                    @endcan
{{--                                    @can(\App\System\Enums\PermissionEnum::VINCULAR_EQUIPE->value)--}}
{{--                                        <a class="btn btn-dark btn-sm" title="Vincular usuário a equipe"--}}
{{--                                           href="{{ route('users.alterar-senha',$equipe->id) }}"><i--}}
{{--                                                class="fas fa-key"></i> </a>--}}
{{--                                    @endcan--}}
                                </td>
                            </tr>
                        @endforeach
                    </x-adminlte-datatable>
                </div>
            </div>
        </div>
    </div>
@stop
