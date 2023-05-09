<div class="row">
    <div class="col-md-12 p-0">
        @include('projetos::planos_teste.casos_teste_novo')
        <form
            action="{{ route('aplicacoes.projetos.planos-teste.casos-teste.vincular',[$idAplicacao, $idProjeto, $idPlanoTeste]) }}"
            method="post"
            class="col-md-9 d-inline"
        >
            <x-adminlte-input
                name="caso_teste"
                label="Vincular caso de teste existente"
                placeholder="Caso de teste"
            >
                <x-slot name="appendSlot">
                        @csrf
                        <input type="hidden" name="caso_teste_id" id="caso_teste_id" value="0">
                        <x-adminlte-button title="Vincular" type="submit" label="" theme="primary" icon="fas fa-arrow-alt-circle-down"/>
                </x-slot>
            </x-adminlte-input>
        </form>

    </div>
</div>
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
            <td>{{ $casoTeste->requisito }}</td>
            <td>{{ $casoTeste->titulo }}</td>
            <td>{{ $casoTeste->status }}</td>
            <td>

                <x-caso-teste-detalhes
                    :registro="$casoTeste"
                />
                 <x-delete-modal
                    :registro="$casoTeste"
                    message="Deseja desvincular caso de teste?"
                    route="{{ route('aplicacoes.projetos.planos-teste.casos-teste.desvincular',[$idAplicacao, $idProjeto, $idPlanoTeste, $casoTeste->id]) }}"
                />

            </td>
        </tr>
    @endforeach
</x-adminlte-datatable>

@section('js')

    <script>
        $(document).ready(function() {
            $( "#caso_teste" ).autocomplete({
                select: function( event, ui ) {
                    console.log(ui.item);
                    $('#caso_teste_id').val(ui.item.id);

                },
                source: function(request, response) {
                    $.ajax({
                        url:  '/projetos/aplicacoes/casos-teste/list',
                        data:{
                            term : request.term
                        },
                        dataType: "json",
                        success: function(data){
                            var resp = $.map(data,function(obj){
                                return {
                                    label:obj.requisito + ' - ' + obj.titulo,
                                    value:obj.requisito + ' - ' + obj.titulo,
                                    id: obj.id
                                };
                            });
                            response(resp);
                        }
                    });
                },
                minLength: 2
            });
        });
    </script>
@stop

