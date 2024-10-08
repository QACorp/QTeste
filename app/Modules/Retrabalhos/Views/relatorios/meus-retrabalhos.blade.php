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
            @foreach($retrabalhos as $retrabalho)
                <tr>
                    <td>{{ $retrabalho->id }}</td>
                    <td>{{ $retrabalho->numero_tarefa }}</td>
                    <td>{{ $retrabalho->data->format('d/m/Y') }}</td>
                    <td>{{ $retrabalho->nome_criador }}</td>
                    <td>{{ $retrabalho->nome_aplicacao }}</td>
                    <td>{{ $retrabalho->nome_projeto }}</td>
                </tr>
            @endforeach
        </x-adminlte-datatable>
    </div>
@endsection
