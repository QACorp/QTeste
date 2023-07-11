@section('plugins.BsCustomFileInput', true)
<x-adminlte-modal
    id="modalMin_uploa_{{ $idModal }}"
    title="Upload de arquivo"
    static-backdrop
>

    <div class="row">
        <div class="col-md-12">
            <div class="row">
                {{ $message }}
            </div>
            <form method="post" action="{{ $routeAction }}" enctype="multipart/form-data">
                @csrf
                <x-adminlte-input-file
                    name="arquivo"
                    igroup-size="md"
                    placeholder="Escolha um arquivo..."
                    legend="Escolher...">
                    <x-slot name="appendSlot">
                        <x-adminlte-button
                            label="Enviar"
                            theme="primary"
                            icon="fas fa-upload"
                            type="submit"
                        />
                    </x-slot>
                </x-adminlte-input-file>

            </form>
            <x-slot name="footerSlot">
                <x-adminlte-button
                    label="Fechar"
                    theme="danger"
                    icon="fas fa-undo"
                    data-dismiss="modal"
                />
            </x-slot>
        </div>
    </div>
</x-adminlte-modal>
<x-adminlte-button
    class="btn-md mb-2"
    theme="primary"
    label="{{ $labelBtnEnviar }}"
    title="Upload"
    icon="fas fa-upload"
    data-toggle="modal"
    data-target="#modalMin_uploa_{{ $idModal }}"
/>
