<x-adminlte-modal
    id="modalMin_inserirCasoTeste"
    title="Inserir Caso de teste"
    static-backdrop
    size="lg"
>

    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12 p-0">
                    <form
                        action="{{ route('aplicacoes.projetos.planos-teste.casos-teste.inserir',[$idAplicacao, $idProjeto, $idPlanoTeste]) }}"
                        method="post"
                    >
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-5">
                                        <x-adminlte-input
                                            label="Título"
                                            name="titulo"
                                            placeholder="Título"
                                            fgroup-class="col-md-12"
                                            value="{{ old('titulo','') }}"
                                            required
                                        />
                                    </div>
                                    <div class="col-md-4">
                                        <x-adminlte-input
                                            label="Requisito"
                                            name="requisito"
                                            placeholder="Requisito"
                                            fgroup-class="col-md-12"
                                            value="{{ old('requisito','') }}"
                                            required
                                        />
                                    </div>
                                    <div class="col-md-3">
                                        <x-adminlte-select
                                            label="Status"
                                            name="status"
                                            id="status"
                                            fgroup-class="col-md-12"
                                            required
                                        >
                                            <option value="">Status</option>
                                            @foreach(\App\Modules\Projetos\Enums\CasoTesteEnum::cases() as $status)
                                                <option value="{{ $status->value }}">{{ $status->value }}</option>

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
                                            required
                                        >
                                            {{ old('cenario','') }}
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
                                            required
                                        >
                                            {{ old('teste','') }}
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
                                            required
                                        >
                                            {{ old('resultado_esperado','') }}
                                        </x-adminlte-textarea>
                                    </div>
                                </div>
                                <div class="row pl-3">
                                    <x-adminlte-button
                                        label="Salvar"
                                        theme="success"
                                        icon="fas fa-save"
                                        type="submit"
                                    />
                                    <x-adminlte-button
                                        class="row ml-3"
                                        label="Cancelar"
                                        theme="primary"
                                        icon="fas fa-undo"
                                        data-dismiss="modal"
                                    />
                                </div>
                            </div>
                            <div class="col-md-3">
                            </div>
                        </div>

                    </form>
                </div>
            </div>

            <x-slot name="footerSlot">

            </x-slot>
        </div>
    </div>
</x-adminlte-modal>
<x-adminlte-button
    theme="warning"
    label="Criar e vincular novo caso de teste"
    class="mb-2"
    title="Inserir"
    icon="fas fa-plus"
    data-toggle="modal"
    data-target="#modalMin_inserirCasoTeste"
/>
