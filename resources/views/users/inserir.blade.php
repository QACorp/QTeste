@extends('adminlte::page')
@section('plugins.Select2', true)
@section('title', 'QTeste - Usuários | Inserir')
@section('content_header')
    <h1 class="m-0 text-dark">Inserir usuário </h1>

@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('users.salvar') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <x-adminlte-input
                                            name="name"
                                            label="Nome"
                                            placeholder="Nome"
                                            fgroup-class="col-md-12"
                                            value="{{ old('name','') }}"
                                            required
                                    />
                                </div>
                                <div class="row">
                                    <x-adminlte-input
                                            name="email"
                                            label="E-mail"
                                            placeholder="algum@email.com"
                                            fgroup-class="col-md-12"
                                            value="{{ old('email','') }}"
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
                                    <a href="{{ route('users.index') }}"
                                       class="btn btn-primary ml-1"
                                    ><i class="fas fa-undo"></i> Cancelar</a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <x-combo-equipes
                                            :idsEquipe="old('equipes',[])"
                                        >
                                        </x-combo-equipes>
                                    </div>
                                </div>
                                <div class="row">
                                    <x-adminlte-select2
                                        id="roles"
                                        name="roles[]"
                                        label="Perfis"
                                        :config="['placeholder' => 'Selecione os perfis...']"
                                        multiple
                                        required
                                        fgroup-class="col-md-12"
                                    >
                                        @foreach(\App\System\Enums\RoleEnum::cases() as $role)
                                            <option @if(collect($userController->convertArrayRoleDTO(old('roles',[])))->where('name',$role->value)->count() > 0))
                                                    selected
                                                    @endif value="{{ $role->value }}">{{ $role->value }}</option>
                                        @endforeach
                                    </x-adminlte-select2>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

