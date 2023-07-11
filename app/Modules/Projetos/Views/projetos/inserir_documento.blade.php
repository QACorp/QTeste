<div class="row">
    @can(\App\Modules\Projetos\Enums\PermissionEnum::ADICIONAR_DOCUMENTO_PROJETO->value)
        <form method="post"
              action="{{ route('aplicacoes.projetos.documento.salvar',[$projeto->aplicacao_id , $projeto->id]) }}">
            @csrf
            <div class="row">
                <div class="col-md-5">
                    <x-adminlte-input
                        name="titulo"
                        label="Título"
                        placeholder=""
                        fgroup-class="col-md-12"
                        value="{{ old('titulo','') }}"
                    />
                </div>
                <div class="col-md-5">
                    <x-adminlte-input
                        name="url"
                        label="URL"
                        placeholder="http://"
                        fgroup-class="col-md-12"
                        value="{{ old('url','') }}"
                    />
                </div>
                <div class="col-md-2 pt-2">
                    <x-adminlte-button
                        label=""
                        class="mt-4"
                        theme="success"
                        icon="fas fa-plus"
                        type="submit"
                    />
                </div>
            </div>
        </form>
    @endcan
</div>
<div class="row">
    <x-adminlte-datatable
        id="documento"
        :heads="[
                          ['label' => 'Documento', 'width' => 15],
                          ['label' => 'Data', 'width' => 6],
                          ['label' => 'Excluir', 'width' => 1]
                ]"
        :config="[
                     ...config('adminlte.datatable_config'),
                     'paging' => false,
                     'searching' => false,
                     'columns' => [['orderable' => false], ['orderable' => false], ['orderable' => false]],
                ]"
        hoverable
        bordered
        striped
    >
        @forelse($documentos as $documento)
            <tr>
                <td><a target="__blank" href="{{ $documento->url }}">{{ $documento->titulo }}</a></td>
                <td>{{ $documento->created_at->format('d/m/Y H\hi') }}</td>
                <td>
                    @can(\App\Modules\Projetos\Enums\PermissionEnum::REMOVER_DOCUMENTO_PROJETO->value)
                        <x-delete-modal
                            :registro="$documento"
                            message="Deseja excluir o registro {{ $documento->titulo }}?"
                            route="{{ route('aplicacoes.projetos.documento.excluir', [$projeto->aplicacao_id, $projeto->id, $documento->id]) }}"
                        />
                    @endcan
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3">Nenhum documento encontrado</td>
            </tr>
        @endforelse
    </x-adminlte-datatable>
</div>

