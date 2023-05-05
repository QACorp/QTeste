<div class="form-group">
    <label for="caso_teste">Caso de teste:</label>
    <input type="text" id="caso_teste" name="caso_teste" class="form-control">
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

                <a class="btn btn-primary btn-sm" title="Visualizar" href="{{ route('aplicacoes.projetos.planos-teste.visualizar',[$idAplicacao, $idProjeto, $casoTeste->id]) }}"><i class="fas fa-eye"></i> </a>
                <x-delete-modal
                    :registro="$casoTeste"
                    message="Deseja excluir o registro {{ $casoTeste->titulo }}?"
                    route="{{ route('aplicacoes.projetos.planos-teste.excluir', [$idAplicacao, $idProjeto, $casoTeste->id]) }}"
                />

            </td>
        </tr>
    @endforeach
</x-adminlte-datatable>

@section('js')

    <script>
        $(document).ready(function() {
            $( "#caso_teste" ).autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url:  '/' +"autocomplete",
                        data:{
                            term : request.term
                        },
                        dataType: "json",
                        success: function(data){
                            console.log(data);
                            var resp = $.map(data,function(obj){
                                return obj.name;
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

