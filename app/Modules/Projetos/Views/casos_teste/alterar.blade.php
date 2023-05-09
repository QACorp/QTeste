@extends('adminlte::page')

@section('title', 'QAKit - Casos de teste | Editar')
@section('content_header')
    <h1 class="m-0 text-dark">Alterar Caso de teste</h1>

@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form
                        action="{{ route('aplicacoes.casos-teste.atualizar',$casoTeste->id) }}"
                        method="post"
                    >
                        @csrf
                        @method('put')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-5">
                                        <x-adminlte-input
                                            label="Título"
                                            name="titulo"
                                            placeholder="Título"
                                            fgroup-class="col-md-12"
                                            value="{{ old('titulo',$casoTeste->titulo) }}"
                                            required
                                        />
                                    </div>
                                    <div class="col-md-4">
                                        <x-adminlte-input
                                            label="Requisito"
                                            name="requisito"
                                            placeholder="Requisito"
                                            fgroup-class="col-md-12"
                                            value="{{ old('requisito',$casoTeste->requisito) }}"
                                            required
                                        />
                                    </div>
                                    <div class="col-md-3">
                                        <x-adminlte-select
                                            label="Status"
                                            name="status"
                                            id="status"
                                            fgroup-class="col-md-12"
                                            required
                                        >
                                            <option value="">Status</option>
                                            @foreach(\App\Modules\Projetos\Enums\CasoTesteEnum::cases() as $status)
                                                <option @if($status->value == old('status', $casoTeste->status)) selected @endif value="{{ $status->value }}">{{ $status->value }}</option>

                                            @endforeach
                                        </x-adminlte-select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <x-adminlte-textarea
                                            label="Cenário"
                                            name="cenario"
                                            placeholder="Quando usuário estiver logado..."
                                            fgroup-class="col-md-12"
                                            required
                                        >
                                            {{ old('cenario',$casoTeste->cenario) }}
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
                                            required
                                        >
                                            {{ old('teste',$casoTeste->teste) }}
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
                                            required
                                        >
                                            {{ old('resultado_esperado',$casoTeste->resultado_esperado) }}
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
