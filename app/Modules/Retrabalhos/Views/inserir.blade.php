@extends('adminlte::page')

@section('title', 'QAKit - Retrabalhos | Inserir')
@section('plugins.Datatables', true)
@section('content_header')
    <h1 class="m-0 text-dark">
        <a href="{{ route('retrabalhos.index') }}" class="btn btn-warning rounded-circle mr-1" title="Voltar para a lista">
            <i class="fas fa-arrow-left"></i>
        </a>Inserir retrabalho
    </h1>

@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body" id="vue">

                    <form-inserir-retrabalho
                        :errors="{{ json_encode($errors->getMessages()) }}"
                        :retrabalho="{
                            descricao: '{{ old('descricao', '') }}',
                            data: '{{ old('data', '') }}',
                            motivo_exclusao: '{{ old('motivo_exclusao', '') }}',
                            tipo_retrabalho_id: {{ old('tipo_retrabalho_id', null) ?? 'null' }},
                            usuario_criador_id: {{ old('usuario_criador_id', null) ?? 'null' }},
                            usuario_id: {{ old('usuario_id', null) ?? 'null' }},
                            projeto_id: {{ old('projeto_id', null)  ?? 'null' }},
                            aplicacao_id: {{ old('aplicacao_id', null)  ?? 'null' }},
                            caso_teste_id: {{ old('caso_teste_id', null)  ?? 'null' }},
                            numero_tarefa: '{{ old('numero_tarefa', '') }}',
                            caso_teste: {
                                titulo_caso_teste: '{{ old('titulo_caso_teste', '') }}',
                                resultado_esperado_caso_teste: '{{ old('resultado_esperado_caso_teste', '') }}',
                                requisito_caso_teste: '{{ old('requisito_caso_teste', '') }}',
                                cenario_caso_teste: '{{ old('cenario_caso_teste', '') }}',
                                teste_caso_teste: '{{ old('teste_caso_teste', '') }}',
                                caso_teste_id: {{ old('caso_teste_id', null) ?? 'null' }}
                            }

                        }"
                        action-form="{{route('retrabalhos.salvar')}}"
                        csrf="{{csrf_token()}}"
                    />

                </div>
            </div>
        </div>
    </div>
@stop
