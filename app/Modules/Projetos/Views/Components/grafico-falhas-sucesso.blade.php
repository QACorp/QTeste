@section('plugins.Chartjs', true)
<div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Testes que passaram x falharam</h3>

        </div>

        <div class="card-body">
            <div><canvas id="falhas_sucesso"></canvas></div>
        </div>
    </div>
</div>

@push('js')
    <script>

        (async function falhasSucesso() {
            const data = [
                { resultado: 'Passou', count: {{ $dados->passou }} },
                { resultado: 'Falhou', count: {{ $dados->falhou }} },
            ];

            new Chart(
                document.getElementById('falhas_sucesso').getContext("2d"),
                {
                    type: 'pie',
                    data: {
                        labels: data.map(row => row.resultado),
                        datasets: [
                            {
                                label: 'Testes',
                                data: data.map(row => row.count)
                            }
                        ]
                    }
                }
            );
        })();

    </script>
@endpush
