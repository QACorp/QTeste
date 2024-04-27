@extends('adminlte::page')

@section('title', 'QAKit - Retrabalhos | Inserir')
@section('plugins.Datatables', true)
@section('content_header')
    <h1 class="m-0 text-dark">Inserir retrabalho </h1>

@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body" id="vue">

                    <form-inserir-retrabalho
                        :errors="{{ json_encode($errors->getMessages()) }}"
                        :retrabalho="{
                            descricao: '{{old('descricao', '')}}',
                            data: '{{old('data', '')}}',
                            motivo_exclusao: '{{old('motivo_exclusao', '')}}',
                            id_tipo_retrabalho: {{old('id_tipo_retrabalho', null) ?? 'null' }},
                            id_usuario_criador: {{old('id_usuario_criador', null) ?? 'null' }},
                            id_usuario: {{old('id_usuario', null) ?? 'null' }},
                            id_projeto: {{old('id_projeto', null)  ?? 'null'}},
                            id_aplicacao: {{old('id_aplicacao', null)  ?? 'null'}},
                            id_caso_teste: {{old('id_caso_teste', null)  ?? 'null'}},
                            numero_tarefa: '{{old('numero_tarefa', '')}}',
                            caso_teste: {
                                titulo_caso_teste: '{{old('titulo_caso_teste', '')}}',
                                resultado_esperado_caso_teste: '{{old('resultado_esperado_caso_teste', '')}}',
                                requisito_caso_teste: '{{old('requisito_caso_teste', '')}}',
                                cenario_caso_teste: '{{old('cenario_caso_teste', '')}}',
                                teste_caso_teste: '{{old('teste_caso_teste', '')}}',
                                id_caso_teste: {{old('id_caso_teste', null) ?? 'null'}}
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
