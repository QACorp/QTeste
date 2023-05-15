
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <x-adminlte-datatable
                        id="planos_teste"
                        :heads="$headsPlanoTesteExecucao"
                        :config="$configPlanoTesteExecucao"
                        compressed
                        hoverable
                        bordered
                        striped
                    >
                        @foreach($planoTesteExecucoes as $planoTesteExecucao)
                            <tr>
                                <td>{{ $planoTesteExecucao->id }}</td>
                                <td>{{ $planoTesteExecucao->created_at->format('d/m/Y \a\s H:i:s') }}</td>
                                <td>{{ $planoTesteExecucao->user->name }}</td>
                                <td>
                                    <span class="badge badge-{{ $planoTesteExecucao->data_execucao == null ? 'warning' : 'success' }}">{{ $planoTesteExecucao->data_execucao == null ? 'Em execução' : $planoTesteExecucao->resultado }}</span>

                                </td>
                                <td>
                                    <a class="btn btn-primary btn-sm" title="Visualizar" href="{{ route('aplicacoes.projetos.planos-teste-execucao.visualizar',[$idAplicacao, $idProjeto, $planoTesteExecucao->plano_teste->id, $planoTesteExecucao->id]) }}"><i class="fas fa-eye"></i> </a>
                                </td>
                            </tr>
                        @endforeach
                    </x-adminlte-datatable>
                </div>
            </div>
        </div>
    </div>

