@extends('adminlte::page')

@section('title', 'QAKit - Projetos')
@section('plugins.Select2', true)
@section('content_header')
    <div class="row">
        <h1 class="m-0 text-dark col-md-8">QAra</h1>
        <div class="text-right col-md-4">

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body">

                    <form action="{{ route('caso-teste.qara.gerar-texto') }}" id="form-caso-teste" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <button class="btn btn-success btn-sm" type="button" onclick="">
                                    <i class="fas fa-plus-circle"></i>
                                </button>
                            </div>
                        @foreach($casosTeste as $key => $casoTeste)

                            <div class="col-md-12 border rounded border-black mb-2 pt-4" id="ct_{{ $key }}">
                                <div class="row">
                                    <div class="col-md-12 text-right">
                                        <button class="btn btn-light btn-sm" type="button" onclick="document.getElementById('ct_{{ $key }}').remove()">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <x-adminlte-input
                                                    label="Título"
                                                    name="titulo[]"
                                                    placeholder="Título"
                                                    fgroup-class="col-md-12"
                                                    value="{{ old('titulo',$casoTeste->titulo) }}"
                                                />
                                            </div>
                                            <div class="col-md-6">
                                                <x-adminlte-input
                                                    label="Requisito"
                                                    name="requisito[]"
                                                    placeholder="Requisito"
                                                    fgroup-class="col-md-12"
                                                    value="{{ old('requisito',$casoTeste->requisito) }}"
                                                />
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <x-adminlte-textarea
                                                    label="Cenário"
                                                    name="cenario[]"
                                                    placeholder="Quando usuário estiver logado..."
                                                    fgroup-class="col-md-12"
                                                >
                                                    {{ old('cenario',$casoTeste->cenario) }}
                                                </x-adminlte-textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <x-adminlte-textarea
                                                    label="Teste"
                                                    name="teste[]"
                                                    placeholder="Clicar no botão..."
                                                    fgroup-class="col-md-12"
                                                >
                                                    {{ old('teste',$casoTeste->teste) }}
                                                </x-adminlte-textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <x-adminlte-textarea
                                                    label="Resultado esperado"
                                                    name="resultado_esperado[]"
                                                    placeholder="Deverá aparecer..."
                                                    fgroup-class="col-md-12"
                                                >
                                                    {{ old('resultado_esperado',$casoTeste->resultado_esperado) }}
                                                </x-adminlte-textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                            <div class="col-md-3">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success btn-md">Salvar</button>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <a href="{{ route('caso-teste.qara.index') }}" class="btn btn-warning btn-md"> <i class="fas fa-arrow-alt-circle-left" ></i> Voltar para formulário</a>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
    <script>

    </script>
@stop
