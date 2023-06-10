@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)
<div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Casos de teste mais executados</h3>

        </div>

        <div class="card-body">
            <x-adminlte-datatable
                id="casos_teste"
                :heads="$heads"
                :config="$config"
                compressed
                hoverable
                bordered
                striped>
                @foreach($casosTeste as $casoTeste)
                    <tr>
                        <td>{{ $casoTeste->id }}</td>
                        <td>{{ $casoTeste->titulo }}</td>
                        <td>{{ $casoTeste->total_execucoes }}</td>
                        <td>
                            <x-caso-teste-detalhes
                                :registro="$casoTeste"
                            />
                        </td>
                    </tr>
                @endforeach
            </x-adminlte-datatable>
        </div>

        <div class="card-footer">
        </div>

    </div>
</div>
