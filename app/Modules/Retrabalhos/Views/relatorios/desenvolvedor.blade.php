@extends('retrabalhos::relatorios.index')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)

@section('relatorio-content')
    <div class="row mt-12">
        <form method="get" id="form-filtro">
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <input type="date" class="form-control" name="dtInicio" id="dtInicio" value="{{ $dtInicio }}" />
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <input type="date" class="form-control" name="dtFim" id="dtFim" value="{{ $dtFim }}" />
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary rounded-circle" >
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>
        <x-adminlte-datatable
            id="table1"
            :heads="$heads"
            :config="$config"
            compressed
            hoverable
            bordered

            striped>
            @forelse($retrabalhos as $retrabalho)
                <tr>
                    <td>{{ $retrabalho->id }}</td>
                    <td>{{ $retrabalho->name }}</td>
                    <td>{{ $retrabalho->tarefas }}</td>
                    <td>{{ $retrabalho->retrabalhos }}</td>
                    <td>{{ $retrabalho->proporcao_retrabalho }}</td>
                    <td>{{ $retrabalho->retrabalhos_analise }}</td>
                    <td>{{ $retrabalho->proporcao_retrabalho_analise }}</td>
                    <td>{{ $retrabalho->retrabalhos_funcionais }}</td>
                    <td>{{ $retrabalho->proporcao_retrabalho_funcionais }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Nenhum registro encontrado</td>
                </tr>
            @endforelse
        </x-adminlte-datatable>
    </div>
@endsection
