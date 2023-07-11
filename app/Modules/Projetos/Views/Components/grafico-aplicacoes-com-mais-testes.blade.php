@section('plugins.Chartjs', true)
<div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Testes por aplicação</h3>

        </div>

        <div class="card-body">
            <div><canvas id="aplicacoes"></canvas></div>
        </div>
    </div>
</div>

@push('js')
    <script>

        (async function aplicacoesComMaisTestes() {
            const data = [
                @foreach($coberturaTesteAplicacao as $aplicacoes)
                { resultado: '{{$aplicacoes->nome}}', count: {{ $aplicacoes->total_testes }} },
                @endforeach

            ];

            new Chart(
                document.getElementById('aplicacoes').getContext("2d"),
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
