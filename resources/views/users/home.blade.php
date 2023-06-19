@extends('adminlte::page')

@section('title', 'QAKit - Usuários')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)
@section('content_header')
    <h1 class="m-0 text-dark">Usuários
        @can(\App\System\Enums\PermissionEnum::INSERIR_USUARIO->value)
            <a class="btn btn-primary" href="{{route('users.inserir')}}"><i class="fas fa-plus"></i> </a>
        @endcan
    </h1>

@stop

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <x-adminlte-datatable
                        id="users"
                        :heads="$heads"
                        :config="$config"
                        compressed
                        hoverable
                        bordered
                        striped>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{   StringUtils::array2String($user->roles->toArray(), 'name') }}</td>
                                <td>
                                    @can(\App\System\Enums\PermissionEnum::ALTERAR_USUARIO->value)
                                        <a class="btn btn-warning btn-sm" title="Editar"
                                           href="{{ route('users.editar',$user->id) }}"><i class="fas fa-edit"></i> </a>
                                    @endcan
                                    @can(\App\System\Enums\PermissionEnum::ALTERAR_SENHA_USUARIO->value)
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
