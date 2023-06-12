@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)
<div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Planos de teste mais executados</h3>

        </div>

        <div class="card-body">
            <x-adminlte-datatable
                id="planos_teste"
                :heads="$heads"
                :config="$config"
                compressed
                hoverable
                bordered
                striped>
                @foreach($planos_teste as $plano_teste)
                    <tr>
                        <td>{{ $plano_teste->id }}</td>
                        <td>{{ $plano_teste->titulo }}</td>
                        <td>{{ $plano_teste->total_execucoes }}</td>
                        <td>

                            <a class="btn btn-primary btn-sm" title="Visualizar" href="{{ route('aplicacoes.projetos.planos-teste.visualizar',[$plano_teste->aplicacao_id, $plano_teste->projeto_id, $plano_teste->id]) }}"><i class="fas fa-eye"></i> </a>

                        </td>
                    </tr>
                @endforeach
            </x-adminlte-datatable>
        </div>
    </div>
</div>
