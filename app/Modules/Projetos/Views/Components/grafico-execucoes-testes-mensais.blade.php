@section('plugins.Chartjs', true)
<div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Execuções mensais</h3>

        </div>

        <div class="card-body">
            <div class="w-100 h-25"><canvas id="execucoes"></canvas></div>
        </div>
    </div>
</div>

@push('js')
    <script>

        (async function falhasSucesso() {
            const data = [
                @foreach($arrayMes as $mes)
                { resultado: '{{ $mes }}', count: {{ $dados->where('data','=', $mes)->first()->quantidade ?? 0 }} },
                @endforeach

            ];

            new Chart(
                document.getElementById('execucoes').getContext("2d"),
                {
                    type: 'line',
                    data: {
                        labels: data.map(row => row.resultado),
                        datasets: [
                            {
                                label: 'Execuções',
                                data: data.map(row => row.count)
                            }
                        ]
                    }
                }
            );
        })();

    </script>
@endpush
