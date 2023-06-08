@extends('adminlte::page')

@section('title', 'QAKit - Casos de teste')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)
@section('content_header')
    <h1 class="m-0 text-dark">Casos de teste</h1>

@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @can(\App\System\Enuns\PermisissionEnum::INSERIR_CASO_TESTE->value)
                        <a class="btn btn-primary mb-2" href="{{route('aplicacoes.casos-teste.inserir')}}"><i class="fas fa-plus"></i> </a>
                    @endcan
                    @can(\App\System\Enuns\PermisissionEnum::IMPORTAR_PLANILHA_CASO_TESTE->value)
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
                                    @can(\App\System\Enuns\PermisissionEnum::ALTERAR_CASO_TESTE->value)
                                    <a class="btn btn-warning btn-sm" title="Alterar" href="{{ route('aplicacoes.casos-teste.editar',$casoTeste->id) }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @endcan
                                    @can(\App\System\Enuns\PermisissionEnum::REMOVER_CASO_TESTE->value)
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
