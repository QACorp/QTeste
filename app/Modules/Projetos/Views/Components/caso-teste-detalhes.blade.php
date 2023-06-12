<x-adminlte-modal
    id="modalDetalhe_{{ $registro->id }}{{ md5(time()) }}"
    title="Visualizar {{ $registro->titulo }}"
    static-backdrop
    size="lg"
>

        <div class="col-md-12">
            <div class="row">
                <div class="col-md-5">
                    <x-adminlte-input
                        label="Título"
                        name="titulo"
                        placeholder="Título"
                        fgroup-class="col-md-12"
                        value="{{ $registro->titulo }}"
                        readonly
                    />
                </div>
                <div class="col-md-4">
                    <x-adminlte-input
                        label="Requisito"
                        name="requisito"
                        placeholder="Requisito"
                        fgroup-class="col-md-12"
                        value="{{ $registro->requisito }}"
                        readonly
                    />
                </div>
                <div class="col-md-3">
                    <x-adminlte-select
                        label="Status"
                        name="status"
                        id="status"
                        fgroup-class="col-md-12"
                        readonly
                    >
                        <option value="">Status</option>
                        @foreach(\App\Modules\Projetos\Enums\CasoTesteEnum::cases() as $status)
                            <option @if($status->value == $registro->status)  selected @endif value="{{ $status->value }}">{{ $status->value }}</option>

                        @endforeach
                    </x-adminlte-select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <x-adminlte-textarea
                        label="Cenário"
                        name="cenario"
                        placeholder="Quando usuário estiver logado..."
                        fgroup-class="col-md-12"
                        readonly
                    >
                        {{ $registro->cenario }}
                    </x-adminlte-textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <x-adminlte-textarea
                        label="Teste"
                        name="teste"
                        placeholder="Clicar no botão..."
                        fgroup-class="col-md-12"
                        readonly
                    >
                        {{ $registro->teste }}
                    </x-adminlte-textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <x-adminlte-textarea
                        label="Resultado esperado"
                        name="resultado_esperado"
                        placeholder="Deverá aparecer..."
                        fgroup-class="col-md-12"
                        readonly
                    >
                        {{ $registro->resultado_esperado }}
                    </x-adminlte-textarea>
                </div>
            </div>
        </div>

        <x-slot name="footerSlot">

            <x-adminlte-button
                label="Fechar"
                theme="success"
                icon="fas fa-undo"
                data-dismiss="modal"
            />
        </x-slot>


</x-adminlte-modal>
<x-adminlte-button
    class="btn-sm"
    theme="primary"
    label=""
    title="Visualizar"
    icon="fas fa-eye"
    data-toggle="modal"
    data-target="#modalDetalhe_{{ $registro->id }}{{ md5(time()) }}"
/>
