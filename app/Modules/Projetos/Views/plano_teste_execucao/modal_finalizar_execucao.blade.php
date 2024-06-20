<x-adminlte-modal
    id="modalFinalizar"
    title="Finalizar execução"
    static-backdrop
>

    <div class="row">
        <div class="col-md-12">
            <div class="row">
                Deseja realmente finalizar a execução?
            </div>

            <x-slot name="footerSlot">
                <form method="post" action="{{ route('aplicacoes.projetos.planos-teste.finalizar', [$idAplicacao, $idProjeto, $planoTesteExecucao->plano_teste->id, $planoTesteExecucao->id]) }}">
                    @csrf
                    <x-adminlte-button
                        label="Finalizar"
                        theme="danger"
                        icon="fas fa-check"
                        type="submit"
                    />
                </form>
                <x-adminlte-button
                    label="Cancelar"
                    theme="success"
                    icon="fas fa-undo"
                    data-dismiss="modal"
                />
            </x-slot>
        </div>
    </div>
</x-adminlte-modal>
<x-adminlte-button
    class="btn-lg"
    theme="success"
    label="Finalizar execução"
    title="Finalizar execução"
    icon="fas fa-check"
    data-toggle="modal"
    data-target="#modalFinalizar"
/>
