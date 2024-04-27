@extends('adminlte::page')

@section('title', 'QAKit - Retrabalhos | Sucesso')
@section('content_header')
    <h1 class="m-0 text-dark">Inserir novo retrabalho </h1>

@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <p>O retrabalho foi cadastrado com sucesso, segue a providência para utilizar ao devolver a tarefa <strong>{{ $retrabalho->numero_tarefa }}</strong> para o desenvolvedor</p>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="border p-2 rounded">
                                Prezado {{ $retrabalho->usuario->name }},<br />
                                foi encontrado o seguinte retrabalho nesta tarefa, favor corrigir.<br />
                                ==================================================== <br />
                                <strong>Descrição:</strong><br /> {{ $retrabalho->descricao }}<br />
                                ====================================================<br />
                                @if($retrabalho->caso_teste)
                                    <strong>CASO DE TESTE #{{ $retrabalho->caso_teste->id }}</strong><br />
                                    ====================================================<br />
                                    <strong>Título:</strong><br />
                                    {{ $retrabalho->caso_teste->titulo }}<br />
                                    ----------------------------------------------------<br />
                                    <strong>Requisito:</strong><br />
                                    {{ $retrabalho->caso_teste->requisito }}<br />
                                    ----------------------------------------------------<br />
                                    <strong>Cenário:</strong><br />
                                    {{ $retrabalho->caso_teste->cenario }}<br />
                                    ----------------------------------------------------<br />
                                    <strong>Teste:</strong><br />
                                    {{ $retrabalho->caso_teste->teste }}<br />
                                    ----------------------------------------------------<br />
                                    <strong>Resultado esperado:</strong><br />
                                    {{ $retrabalho->caso_teste->resultado_esperado }}<br />
                                    ====================================================<br />
                                @endif
                                <small class="font-monospace">Retrabalho: #{{ $retrabalho->id }} | Data de cadastro: {{ $retrabalho->data->format('d/m/Y')}}</small>
                            </div>
                            <button onclick="window.print()" class="btn btn-primary mt-2">Copiar</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
