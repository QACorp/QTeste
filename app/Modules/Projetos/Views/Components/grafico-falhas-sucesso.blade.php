@section('plugins.Chartjs', true)
<div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Testes que passaram x falharam</h3>

        </div>

        <div class="card-body">
            <div><canvas id="acquisitions"></canvas></div>
        </div>
    </div>
</div>

@section('js')
    <script>

        (async function() {
            const data = [
                { resultado: 'Passou', count: {{ $dados->passou }} },
                { resultado: 'Falhou', count: {{ $dados->falhou }} },
            ];

            new Chart(
                document.getElementById('acquisitions'),
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
@stop
