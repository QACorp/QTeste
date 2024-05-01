@php
    use App\Modules\Retrabalhos\Contracts\Business\RetrabalhoBusinessContract;
    use Illuminate\Support\Facades\Auth;
@endphp
@extends('adminlte::page')

@section('title', 'QAKit - Retrabalhos')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)
@section('content_header')
    <div class="row">
        <h1 class="m-0 text-dark col-md-8">Retrabalhos</h1>
        <div class="text-right col-md-4">
            @can(\App\Modules\Retrabalhos\Enums\PermissionEnum::INSERIR_RETRABALHO->value)
                <a title="Inserir Retrabalho" class="btn btn-primary"
                   href="{{route('retrabalhos.inserir')}}"><i class="fas fa-plus"></i> Inserir retrabalho</a>
            @endcan
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <x-adminlte-datatable
                        id="table1"
                        :heads="$heads"
                        :config="$config"
                        compressed
                        hoverable
                        bordered
                        beautify
                        striped>
                        @forelse($retrabalhos as $retrabalho)
                            <tr>
                                <td>{{ $retrabalho->id }}</td>
                                <td>{{ $retrabalho->data->format('d/m/Y') }}</td>
                                <td>{{ $retrabalho->numero_tarefa }}</td>
                                <td>{{ $retrabalho->usuario->name }}</td>
                                <td>{{ $retrabalho->usuario_criador->name }}</td>
                                <td>
                                    @if(App::make(RetrabalhoBusinessContract::class)->canAlterarRetrabalho($retrabalho, Auth::user()->getAuthIdentifier()))

                                        <a class="btn btn-warning btn-sm" title="Editar"
                                           href="{{ route('retrabalhos.alterar.index',$retrabalho->id) }}"><i
                                                class="fas fa-edit"></i> </a>
                                    @endif

                                    @if(App::make(RetrabalhoBusinessContract::class)->canRemoverRetrabalho($retrabalho, Auth::user()->getAuthIdentifier()))
                                        <x-delete-modal
                                            :registro="$retrabalho"
                                            message="Deseja excluir o retrabalho #{{ $retrabalho->id }}?"
                                            route="{{ route('retrabalhos.remover', [ $retrabalho->id]) }}"
                                        />
                                    @endif

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">Nenhum registro encontrado</td>
                            </tr>
                        @endforelse
                    </x-adminlte-datatable>
                </div>
            </div>
        </div>
    </div>
@stop
