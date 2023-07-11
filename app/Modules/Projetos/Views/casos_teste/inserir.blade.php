@extends('adminlte::page')

@section('title', 'QAKit - Casos de teste | Inserir')
@section('content_header')
    <h1 class="m-0 text-dark">Inserir Caso de teste</h1>

@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form
                        action="{{ route('aplicacoes.casos-teste.salvar') }}"
                        method="post"
                    >
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-5">
                                        <x-adminlte-input
                                            label="Título"
                                            name="titulo"
                                            placeholder="Título"
                                            fgroup-class="col-md-12"
                                            value="{{ old('titulo','') }}"
                                        />
                                    </div>
                                    <div class="col-md-5">
                                        <x-adminlte-input
                                            label="Requisito"
                                            name="requisito"
                                            placeholder="Requisito"
                                            fgroup-class="col-md-12"
                                            value="{{ old('requisito','') }}"
                                        />
                                    </div>
                                    <div class="col-md-2">
                                        <x-adminlte-select
                                            label="Status"
                                            name="status"
                                            id="status"
                                            fgroup-class="col-md-12"
                                        >
                                            <option value="" @if("" == old('status', "")) selected @endif>Status</option>
                                            @foreach(\App\Modules\Projetos\Enums\CasoTesteEnum::cases() as $status)
                                                <option @if($status->value == old('status', "")) selected @endif value="{{ $status->value }}">{{ $status->value }}</option>

                                            @endforeach
                                        </x-adminlte-select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <x-combo-equipes
                                            :idsEquipe="old('equipes',[])"
                                        >
                                        </x-combo-equipes>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <x-adminlte-textarea
                                            label="Cenário"
                                            name="cenario"
                                            placeholder="Quando usuário estiver logado..."
                                            fgroup-class="col-md-12"
                                        >
                                            {{ old('cenario',"") }}
                                        </x-adminlte-textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <x-adminlte-textarea
                                            label="Teste"
                                            name="teste"
                                            placeholder="Clicar no botão..."
                                            fgroup-class="col-md-12"
                                        >
                                            {{ old('teste',"") }}
                                        </x-adminlte-textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <x-adminlte-textarea
                                            label="Resultado esperado"
                                            name="resultado_esperado"
                                            placeholder="Deverá aparecer..."
                                            fgroup-class="col-md-12"
                                        >
                                            {{ old('resultado_esperado',"") }}
                                        </x-adminlte-textarea>
                                    </div>
                                </div>
                                <div class="row pl-3">
                                    <x-adminlte-button
                                        label="Salvar"
                                        theme="success"
                                        icon="fas fa-save"
                                        type="submit"
                                    />
                                    <a href="{{ route('aplicacoes.casos-teste.index') }}"
                                       class="btn btn-primary ml-1"
                                    >
                                        <i class="fas fa-undo"></i> Voltar para lista
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-3">

                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
