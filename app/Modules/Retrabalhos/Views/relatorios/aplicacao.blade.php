@extends('retrabalhos::relatorios.index')
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
            id="perApplication"
            :heads="$heads"
            :config="$config"
            compressed
            hoverable
            bordered
            data-page-length='100'
            striped>
            @forelse($retrabalhos as $retrabalho)
                <tr>
                    <td>{{ $retrabalho->id_aplicacao }}</td>
                    <td>{{ $retrabalho->nome }}</td>
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
                    <td colspan="9">Nenhum registro encontrado</td>
                </tr>
            @endforelse
        </x-adminlte-datatable>
    </div>
@endsection
