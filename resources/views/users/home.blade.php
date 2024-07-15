@php
    use App\System\Enums\PermissionEnum;
@endphp
@extends('adminlte::page')

@section('title', 'QTeste - Usuários')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)
@section('content_header')
    <div class="row">
        <h1 class="m-0 text-dark col-md-4">Usuários</h1>
        <div class="text-right col-md-8">
            @can(PermissionEnum::INSERIR_USUARIO->value)
                <a class="btn btn-primary" href="{{route('users.inserir')}}"><i class="fas fa-plus"></i> Inserir usuário</a>
            @endcan
        </div>
    </div>

@stop

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @can(PermissionEnum::INSERIR_USUARIO->value)
                        <x-upload-modal
                            idModal="uploadPlanilhaUser"
                            message="Selecione o arquivo para importar"
                            routeAction="{{ route('users.upload') }}"
                            labelBtnEnviar="Importar usuários"
                        >
                            <div class="row">
                                <div class="col-md-6">
                                    <x-combo-equipes
                                        :idsEquipe="old('equipes',[])"
                                    >
                                    </x-combo-equipes>
                                </div>
                            </div>
                        </x-upload-modal>
                    @endcan
                    <x-adminlte-datatable
                        id="users"
                        :heads="$heads"
                        :config="$config"
                        compressed
                        hoverable
                        bordered
                        striped>
                        @foreach($users as $user)
                            <tr >
                                <td class="@if(!$user->active) text-danger @endif">{{ $user->id }}</td>
                                <td class="@if(!$user->active) text-danger @endif">{{ $user->name }}</td>
                                <td class="@if(!$user->active) text-danger @endif">{{ $user->email }}</td>
                                <td class="@if(!$user->active) text-danger @endif">{{   StringUtils::array2String($user->roles->toArray(), 'name') }}</td>
                                <td>
                                    @can(PermissionEnum::ALTERAR_USUARIO->value)
                                        <a class="btn btn-warning btn-sm" title="Editar"
                                           href="{{ route('users.editar',$user->id) }}"><i class="fas fa-edit"></i> </a>
                                    @endcan
                                    @can(PermissionEnum::ALTERAR_SENHA_USUARIO->value)
                                        <a class="btn btn-dark btn-sm" title="Alterar senha"
                                           href="{{ route('users.alterar-senha',$user->id) }}"><i
                                                class="fas fa-key"></i> </a>
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
