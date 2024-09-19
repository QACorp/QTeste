@extends('adminlte::page')
@section('plugins.Jquery', true)
@section('title', 'QTeste - Retrabalhos | Sucesso')
@section('content_header')
    <h1 class="m-0 text-dark">Inserir novo retrabalho </h1>

@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <p>O retrabalho foi cadastrado com sucesso, segue a providência para utilizar ao devolver a tarefa <strong>{{ $retrabalho->tarefa->tarefa }}    </strong> para o desenvolvedor</p>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="border p-2 rounded" id="providencia">
                                Prezado {{ $retrabalho->usuario->name }},<br />
                                foi encontrado o seguinte retrabalho nesta tarefa, favor corrigir.<br />
                                ==================================================== <br />
                                <strong>Descrição:</strong><br />
                                {!! strip_tags(nl2br($retrabalho->descricao),['<br />','<br>']) !!}<br />
                                ====================================================<br />
                                @if($retrabalho->caso_teste)
                                    <strong>CASO DE TESTE #{{ $retrabalho->caso_teste->id }}</strong><br />
                                    ====================================================<br />
                                    <strong>Título:</strong><br />
                                    {!! strip_tags(nl2br($retrabalho->caso_teste->titulo),['<br />','<br>']) !!}<br />
                                    ----------------------------------------------------<br />
                                    <strong>Requisito:</strong><br />
                                    {!! strip_tags(nl2br($retrabalho->caso_teste->requisito),['<br />','<br>']) !!}<br />
                                    ----------------------------------------------------<br />
                                    <strong>Cenário:</strong><br />
                                    {!! strip_tags(nl2br($retrabalho->caso_teste->cenario),['<br />','<br>']) !!}<br />
                                    ----------------------------------------------------<br />
                                    <strong>Teste:</strong><br />
                                    {!!  strip_tags(nl2br($retrabalho->caso_teste->teste),['<br />','<br>']) !!}<br />
                                    ----------------------------------------------------<br />
                                    <strong>Resultado esperado:</strong><br />
                                    {!! strip_tags(nl2br($retrabalho->caso_teste->resultado_esperado),['<br />','<br>']) !!}<br />
                                    ====================================================<br />
                                @endif

                                <small class="font-monospace">Retrabalho: #{{ $retrabalho->id }} | Data de cadastro: {{ $retrabalho->data->format('d/m/Y')}}</small> <br />
                                --<br />
                                <x-assinatura></x-assinatura>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-1 ">
                                    <a href="{{ route('retrabalhos.index') }}" class="btn btn-warning py-2 col-md-12" title="Voltar para a lista">
                                        <i class="fas fa-arrow-left"></i>
                                    </a>
                                </div>
                                @can(\App\Modules\Retrabalhos\Enums\PermissionEnum::INSERIR_RETRABALHO->value)
                                <div class="col-md-3 ">
                                    <a href="{{ route('retrabalhos.inserir') }}" class="btn btn-success py-2 col-md-12">Inserir novo retrabalho</a>
                                </div>
                                @endcan
                                <div class="col-md-4 ">
                                    <button id="copy" data-clipboard-target="#providencia" class="btn btn-primary py-2 col-md-12">Copiar para área de transferência</button>
                                </div>
                                <div class="col-md-4">
                                    <div class="alert alert-success fade hidden py-2 mr-1" role="alert" id="cliped">
                                        Providência copiada com sucesso!
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.11/clipboard.min.js"></script>
    <script>

        var clipboard = new ClipboardJS('#copy');

        clipboard.on('success', function(e) {
            $("#cliped").addClass('show');
            e.clearSelection();

        });
        setTimeout(() => {
            $("#cliped").removeClass('show')
        }, 5000);


    </script>
@endpush
