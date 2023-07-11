<div class="card">
    <div class="card-header">
        Planos de teste
        @can(\App\Modules\Projetos\Enums\PermissionEnum::INSERIR_PLANO_TESTE->value)
            <a class="btn btn-primary btn-sm"
               href="{{route('aplicacoes.projetos.planos-teste.inserir',[$projeto->aplicacao_id, $projeto->id])}}"><i
                    class="fas fa-plus"></i></a>
        @endcan
    </div>
    <div class="card-body">

        <x-adminlte-datatable
            id="planos_teste"
            :heads="$headsPlanoTeste"
            :config="$configPlanoTeste"
            compressed
            hoverable
            bordered
            striped>
            @foreach($planosTeste as $plano_teste)
                <tr>
                    <td>{{ $plano_teste->id }}</td>
                    <td>{{ $plano_teste->titulo }}</td>
                    <td>

                        <a class="btn btn-primary btn-sm" title="Visualizar"
                           href="{{ route('aplicacoes.projetos.planos-teste.visualizar',[$projeto->aplicacao_id, $projeto->id, $plano_teste->id]) }}"><i
                                class="fas fa-eye"></i> </a>
                        @can(\App\Modules\Projetos\Enums\PermissionEnum::REMOVER_PLANO_TESTE->value)
                            <x-delete-modal
                                :registro="$plano_teste"
                                message="Deseja excluir o registro {{ $plano_teste->titulo }}?"
                                route="{{ route('aplicacoes.projetos.planos-teste.excluir', [$projeto->aplicacao_id, $projeto->id, $plano_teste->id]) }}"
                            />
                        @endcan

                    </td>
                </tr>
            @endforeach
        </x-adminlte-datatable>
    </div>
</div>

