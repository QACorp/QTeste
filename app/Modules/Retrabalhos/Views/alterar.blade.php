@php
    use App\Modules\Retrabalhos\Enums\CriticidadeEnum;
@endphp
@extends('adminlte::page')

@section('title', 'QTeste - Retrabalhos | Alterar')
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
                <div class="card-body">

                    <form-inserir-retrabalho
                        :errors="{{ json_encode($errors->getMessages()) }}"
                        method="PUT"
                        :criticidades="{{ json_encode(CriticidadeEnum::cases()) }}"
                        :retrabalho="{
                            descricao: '{{str_replace("\r\n", '\r\n', old('descricao', $retrabalho->descricao))}}',
                            data: '{{old('data', $retrabalho->data->format('Y-m-d'))}}',
                            motivo_exclusao: '{{old('motivo_exclusao', $retrabalho->motivo_exclusao)}}',
                            tipo_retrabalho_id: {{old('tipo_retrabalho_id', $retrabalho->tipo_retrabalho_id) ?? 'null' }},
                            usuario_criador_id: {{old('usuario_criador_id', $retrabalho->usuario_criador_id) ?? 'null' }},
                            usuario_id: {{old('usuario_id',$retrabalho->usuario_id ) ?? 'null' }},
                            projeto_id: {{old('projeto_id', $retrabalho->projeto_id)  ?? 'null'}},
                            aplicacao_id: {{old('aplicacao_id', $retrabalho->aplicacao_id)  ?? 'null'}},
                            caso_teste_id: {{old('caso_teste_id', $retrabalho->caso_teste_id)  ?? 'null'}},
                            numero_tarefa: '{{old('numero_tarefa', $retrabalho->numero_tarefa)}}',
                            criticidade: '{{ old('criticidade', $retrabalho->criticidade) }}',
                            caso_teste: {
                                titulo_caso_teste: '{{str_replace("\r\n", '\r\n', old('titulo_caso_teste', $retrabalho->titulo_caso_teste))}}',
                                resultado_esperado_caso_teste: '{{str_replace("\r\n", '\r\n', old('resultado_esperado_caso_teste', $retrabalho->resultado_esperado_caso_teste))}}',
                                requisito_caso_teste: '{{str_replace("\r\n", '\r\n', old('requisito_caso_teste', $retrabalho->requisito_caso_teste))}}',
                                cenario_caso_teste: '{{str_replace("\r\n", '\r\n', old('cenario_caso_teste', $retrabalho->cenario_caso_teste))}}',
                                teste_caso_teste: '{{str_replace("\r\n", '\r\n', old('teste_caso_teste', $retrabalho->teste_caso_teste))}}',
                                caso_teste_id: {{old('caso_teste_id', $retrabalho->caso_teste_id) ?? 'null'}}
                            }

                        }"
                        action-form="{{route('retrabalhos.editar',$retrabalho->id)}}"
                        csrf="{{csrf_token()}}"></form-inserir-retrabalho>

                </div>
            </div>
        </div>
    </div>
@stop
