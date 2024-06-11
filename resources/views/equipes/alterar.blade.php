@extends('adminlte::page')
@section('plugins.Select2', true)
@section('title', 'QTeste - Equipes | Alterar')
@section('content_header')
    <h1 class="m-0 text-dark">Alterar equipe </h1>

@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('equipes.atualizar',$idEquipe) }}">
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
                                            value="{{ old('nome',$equipe->nome) }}"
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
                                    <a href="{{ route('equipes.index') }}"
                                       class="btn btn-primary ml-1"
                                    ><i class="fas fa-undo"></i> Cancelar</a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <x-adminlte-select2
                                        id="users"
                                        name="users[]"
                                        label="Membros"
                                        :config="['placeholder' => 'Selecione os membros da equipe...']"
                                        multiple
                                        required
                                        fgroup-class="col-md-12"
                                    >
                                        @foreach($users as $user)
                                            <option
                                                @if(in_array($user->id, old('users',$idUsers))) selected @endif
                                                    value="{{ $user->id }}">{{ $user->name }}</option>
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

