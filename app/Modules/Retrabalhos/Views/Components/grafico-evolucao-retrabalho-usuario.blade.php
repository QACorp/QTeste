
@section('plugins.Chartjs', true)
<div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Retrabalhos por usuário</h3>

        </div>

        <div class="card-body">
            <div><canvas id="retrabalhos-aplicacao-anual-usuario"></canvas></div>
        </div>
    </div>
</div>

@push('js')
    <script>

        (async function comparacaoAnualUsuario() {
            const datasets =
                {
                    labels: {!! json_encode(array_values($meses->toArray()),JSON_UNESCAPED_UNICODE) !!},
                    datasets: [
                            @foreach($aplicacoes as $key => $aplicacao)
                        {
                            label: '{{ $aplicacao->nome }}',
                            data: [@foreach($meses as $keyMes => $mes)
                                    {{ $dadosAnoAtual
                                            ->where('mes','=', $keyMes)
                                            ->where('aplicacao_id','=', $aplicacao->id)
                                            ->first()?->total_retrabalho ?? 0 }},
                                @endforeach]

                        },
                        @endforeach
                    ]
                };

            new Chart(
                document.getElementById('retrabalhos-aplicacao-anual-usuario').getContext("2d"),
                {
                    type: 'line',
                    data: datasets
                }
            );
        })();

    </script>
@endpush
