@extends('adminlte::page')

@section('title', 'QAKit - Aplicações | Projetos | Planos de Teste | Executar')
@section('plugins.Datatables', true)
@section('plugins.JqueryUi', true)
@section('content_header')
    <h1 class="m-0 text-dark">Execução do plano de teste <strong>{{ $planoTesteExecucao->plano_teste->titulo }}</strong></h1>

@stop

@section('content')
    @if($planoTesteExecucao->resultado != null)
        <div class="row">
            <div class="col-12 m-0">
                <div class="card">
                    <div class="card-body bg-{{$planoTesteExecucao->resultado == \App\Modules\Projetos\Enums\PlanoTesteExecucaoEnum::PASSOU->value ? 'success' : 'danger' }}">
                        <div class="jumbotron jumbotron-fluid bg-transparent p-0">
                            <div class="container">
                                <p class="lead">
                                    Esta execução foi concluída em <strong>{{ $planoTesteExecucao->data_execucao->format('d/m/Y \a\s H:i') }}</strong> por <strong>{{ $planoTesteExecucao->user->name }}</strong> com o seguinte resultado:
                                </p>
                                <h3 class="display-3">{{ $planoTesteExecucao->resultado }}</h3>
                                <hr class="my-4">
                                <a class="btn btn-{{$planoTesteExecucao->resultado == \App\Modules\Projetos\Enums\PlanoTesteExecucaoEnum::PASSOU->value ? 'success' : 'danger' }} btn-lg"
                                   href="{{ route('aplicacoes.projetos.planos-teste.criar',[$idAplicacao, $idProjeto, $planoTesteExecucao->plano_teste->id]) }}"
                                   role="button"
                                >
                                    Gerar uma nova execução
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="row">

        <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            Casos de teste
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <a class="btn btn-warning" href="{{route('aplicacoes.projetos.planos-teste.visualizar',[$idAplicacao, $idProjeto, $planoTesteExecucao->plano_teste->id])}}"><i class="fas fa-undo"></i> Voltar para plano de teste</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
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
                                                        @php $casoTesteExiste = $casoTesteExecucaoBusiness->casoTesteExecutado($planoTesteExecucao->id, $casoTeste->id)  @endphp
                                                        <div class="row mt-2 bg-gray-light rounded-bottom rounded-top p-3">
                                                            @if(!$casoTesteExiste && $planoTesteExecucao->resultado == null)
                                                                <div class="col-md-1">
                                                                    <form method="post" action="{{ route('aplicacoes.projetos.planos-teste.executar-caso-teste', [$idAplicacao, $idProjeto, $planoTesteExecucao->plano_teste->id, $planoTesteExecucao->id, $casoTeste->id]) }}">
                                                                        @csrf
                                                                        <input type="hidden" name="status" value="{{ \App\Modules\Projetos\Enums\PlanoTesteExecucaoEnum::PASSOU->value }}" />

                                                                            <x-adminlte-button
                                                                                label="Passou"
                                                                                theme="success"
                                                                                icon="fas fa-check"
                                                                                type="submit"
                                                                            />
                                                                    </form>
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <form method="post" action="{{ route('aplicacoes.projetos.planos-teste.executar-caso-teste', [$idAplicacao, $idProjeto, $planoTesteExecucao->plano_teste->id, $planoTesteExecucao->id, $casoTeste->id]) }}">
                                                                        @csrf
                                                                        <input type="hidden" name="status" value="{{ \App\Modules\Projetos\Enums\PlanoTesteExecucaoEnum::FALHOU->value }}" />
                                                                        <x-adminlte-button
                                                                            label="Falhou"
                                                                            theme="danger"
                                                                            icon="fas fa-bug"
                                                                            type="submit"
                                                                        />
                                                                    </form>
                                                                </div>
                                                            @else
                                                                <div class="col-md-12">

                                                                    @if( $casoTesteExiste && $casoTesteExiste->resultado == \App\Modules\Projetos\Enums\PlanoTesteExecucaoEnum::PASSOU->value)
                                                                        <p><i class="fas fa-check"></i> Passou</p>
                                                                    @elseif($casoTesteExiste && $casoTesteExecucaoBusiness->casoTesteExecutado($planoTesteExecucao->id, $casoTeste->id)->resultado == \App\Modules\Projetos\Enums\PlanoTesteExecucaoEnum::FALHOU->value)

                                                                        <p><i class="fas fa-bug"></i> Falhou</p>
                                                                    @else
                                                                        <p><i class="far fa-times-circle"></i> Abandonado</p>
                                                                    @endif

                                                                </div>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        @if($casosTeste->count() > 0 && $planoTesteExecucao->resultado == null)
                                                <div class="row mt-2 bg-gray-light rounded-bottom rounded-top p-3">
                                                    @include('projetos::plano_teste_execucao.modal_finalizar_execucao')
                                                </div>
                                        @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
