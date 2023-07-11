@extends('adminlte::page')
@section('plugins.Select2', true)
@section('title', 'QAKit - Usuários | Alterar Senha')
@section('content_header')
    <h1 class="m-0 text-dark"><i class="fas fa-key"></i> Alterar senha </h1>

@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('users.atualizar-senha',$user->id) }}">
                        @csrf
                        @method('put')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <x-adminlte-input
                                        value="{{ $user->email }}"
                                        name="usuario"
                                        label="E-mail"
                                        readonly
                                        fgroup-class="col-md-6"
                                    >
                                        <x-slot name="prependSlot">
                                            <div class="input-group-text bg-dark">
                                                <i class="fas fa-user"></i>
                                            </div>
                                        </x-slot>
                                    </x-adminlte-input>
                                </div>
                                <div class="row">
                                    <x-adminlte-input
                                        name="password"
                                        label="Senha"
                                        placeholder="Senha"
                                        type="password"
                                        fgroup-class="col-md-6"
                                        required
                                        value="{{ old('password','') }}"
                                    >
                                        <x-slot name="prependSlot">
                                            <div class="input-group-text bg-dark">
                                                <i class="fas fa-key"></i>
                                            </div>
                                        </x-slot>
                                    </x-adminlte-input>
                                </div>
                                <div class="row">
                                    <x-adminlte-input
                                        name="password_confirmation"
                                        label="Confirmar senha"
                                        placeholder="Digite a senha novamente"
                                        type="password"
                                        fgroup-class="col-md-6"
                                        value="{{ old('password_confirmation','') }}"
                                        required
                                    >
                                        <x-slot name="prependSlot">
                                            <div class="input-group-text bg-dark">
                                                <i class="fas fa-key"></i>
                                            </div>
                                        </x-slot>
                                    </x-adminlte-input>
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

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

