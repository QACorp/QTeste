<x-adminlte-modal
    id="modalMin_{{ $registro->id }}"
    title="Excluir registro"
    static-backdrop
>

    <div class="row">
        <div class="col-md-12">
            <div class="row">
                {{ $message }}
            </div>

            <x-slot name="footerSlot">
                <form method="post" action="{{ $route }}">
                    @csrf
                    @method('delete')
                    <x-adminlte-button
                        label="Excluir"
                        theme="danger"
                        icon="fas fa-trash"
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
    class="btn-sm"
    theme="danger"
    label=""
    title="Excluir"
    icon="fas fa-trash"
    data-toggle="modal"
    data-target="#modalMin_{{ $registro->id }}"
/>
