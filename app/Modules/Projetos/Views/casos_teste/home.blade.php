    @extends('adminlte::page')

@section('title', 'QTeste - Casos de teste')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)
@section('content_header')
    <div class="row">
        <h1 class="m-0 text-dark col-md-9">Casos de teste</h1>
        <div class="text-right col-md-3">
            @can(\App\Modules\Projetos\Enums\PermissionEnum::INSERIR_CASO_TESTE->value)
                <a class="btn btn-primary mb-2" href="{{route('aplicacoes.casos-teste.inserir')}}"><i
                        class="fas fa-plus"></i> Inserir caso de teste</a>
            @endcan
        </div>
    </div>

@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    @can(\App\Modules\Projetos\Enums\PermissionEnum::IMPORTAR_PLANILHA_CASO_TESTE->value)
                        <x-upload-modal
                            idModal="uploadPlanilha"
                            message="Selecione o arquivo para importar"
                            routeAction="{{ route('aplicacoes.casos-teste.upload-caso-teste') }}"
                            labelBtnEnviar="Importar casos de teste de arquivo"
                        />

                    @endcan
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
                                    @can(\App\Modules\Projetos\Enums\PermissionEnum::ALTERAR_CASO_TESTE->value)
                                        <a class="btn btn-warning btn-sm" title="Alterar"
                                           href="{{ route('aplicacoes.casos-teste.editar',$casoTeste->id) }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endcan
                                    @can(\App\Modules\Projetos\Enums\PermissionEnum::REMOVER_CASO_TESTE->value)
                                        <x-delete-modal
                                            :registro="$casoTeste"
                                            message="Deseja excluir caso de teste?"
                                            route="{{ route('aplicacoes.casos-teste.excluir',$casoTeste->id) }}"
                                        />
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </x-adminlte-datatable>
                </div>
            </div>
        </div>
    </div>
@stop
