@extends('adminlte::page')

@section('title', 'QAKit - Aplicações | Projetos | Planos de Teste | Executar')
@section('plugins.Datatables', true)
@section('plugins.JqueryUi', true)
@section('content_header')
    <h1 class="m-0 text-dark">Plano de teste <strong>{{ $planoTesteExecucao->plano_teste->titulo }}</strong></h1>

@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            Casos de teste
                        </div>
                        <div class="card-body">
                            <div class="accordion" id="accordionExample">
                                @foreach($casosTeste as $casoTeste)
                                    <div class="card">
                                        <div class="card-header" id="headingOne">
                                            <h2 class="mb-0">
                                                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                    {{ $casoTeste->titulo }}
                                                </button>
                                            </h2>
                                        </div>
                                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                            <div class="card-body">
                                                <div class="row">
                                                    <strong>Cenário:</strong>
                                                    {!! nl2br($casoTeste->cenario) !!}
                                                </div>
                                                <div class="row">
                                                    <p class="d-block"><strong>Teste:</strong></p>
                                                    {!! nl2br($casoTeste->teste) !!}

                                                </div>
                                                <div class="row">
                                                    <strong>Resultado esperado:</strong>
                                                    {!! nl2br($casoTeste->resultado_esperado) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
