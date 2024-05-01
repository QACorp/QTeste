@extends('adminlte::page')

@section('title', 'QAKit - Retrabalhos | Alterar')
@section('plugins.Datatables', true)
@section('content_header')
    <h1 class="m-0 text-dark">
        <a href="{{ route('retrabalhos.index') }}" class="btn btn-warning rounded-circle mr-1" title="Voltar para a lista">
            <i class="fas fa-arrow-left"></i>
        </a>
        Alterar retrabalho
    </h1>

@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body" id="vue">

                    <form-inserir-retrabalho
                        :errors="{{ json_encode($errors->getMessages()) }}"
                        method="PUT"
                        :retrabalho="{
                            descricao: '{{old('descricao', $retrabalho->descricao)}}',
                            data: '{{old('data', $retrabalho->data->format('Y-m-d'))}}',
                            motivo_exclusao: '{{old('motivo_exclusao', $retrabalho->motivo_exclusao)}}',
                            tipo_retrabalho_id: {{old('tipo_retrabalho_id', $retrabalho->tipo_retrabalho_id) ?? 'null' }},
                            usuario_criador_id: {{old('usuario_criador_id', $retrabalho->usuario_criador_id) ?? 'null' }},
                            usuario_id: {{old('usuario_id',$retrabalho->usuario_id ) ?? 'null' }},
                            projeto_id: {{old('projeto_id', $retrabalho->projeto_id)  ?? 'null'}},
                            aplicacao_id: {{old('aplicacao_id', $retrabalho->aplicacao_id)  ?? 'null'}},
                            caso_teste_id: {{old('caso_teste_id', $retrabalho->caso_teste_id)  ?? 'null'}},
                            numero_tarefa: '{{old('numero_tarefa', $retrabalho->numero_tarefa)}}',
                            caso_teste: {
                                titulo_caso_teste: '{{old('titulo_caso_teste', $retrabalho->titulo_caso_teste)}}',
                                resultado_esperado_caso_teste: '{{old('resultado_esperado_caso_teste', $retrabalho->resultado_esperado_caso_teste)}}',
                                requisito_caso_teste: '{{old('requisito_caso_teste', $retrabalho->requisito_caso_teste)}}',
                                cenario_caso_teste: '{{old('cenario_caso_teste', $retrabalho->cenario_caso_teste)}}',
                                teste_caso_teste: '{{old('teste_caso_teste', $retrabalho->teste_caso_teste)}}',
                                caso_teste_id: {{old('caso_teste_id', $retrabalho->caso_teste_id) ?? 'null'}}
                            }

                        }"
                        action-form="{{route('retrabalhos.editar',$retrabalho->id)}}"
                        csrf="{{csrf_token()}}"
                    />

                </div>
            </div>
        </div>
    </div>
@stop
