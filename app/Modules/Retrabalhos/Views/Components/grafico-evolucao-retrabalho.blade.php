
@section('plugins.Chartjs', true)
<div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Retrabalhos {{ $ano - 1 }} x {{ $ano }}</h3>

        </div>

        <div class="card-body">
            <div><canvas id="retrabalhos-anual"></canvas></div>
        </div>
    </div>
</div>

@push('js')
    <script>

        (async function comparacaoAnual() {
            const dataAnterior = [
                @foreach($meses as $key => $mes)
                    { resultado: '{{ $mes }}', total: {{ $dadosAnoAnterior->where('mes','=', $key)->first()?->total_retrabalho ?? 0 }} },
                @endforeach

            ];
            const dataAtual = [
                @foreach($meses as $key => $mes)
                    { resultado: '{{ $mes }}', total: {{ $dadosAnoAtual->where('mes', '=', $key)->first()?->total_retrabalho ?? 0 }} },
                @endforeach

            ];

            new Chart(
                document.getElementById('retrabalhos-anual').getContext("2d"),
                {
                    type: 'line',
                    data: {
                        labels: dataAnterior.map(row => row.resultado),
                        datasets: [
                            {
                                label: '{{ $ano - 1 }}',
                                data: dataAnterior.map(row => row.total)
                            },
                            {
                                label: '{{ $ano }}',
                                data: dataAtual.map(row => row.total)
                            }
                        ]
                    }
                }
            );
        })();

    </script>
@endpush
