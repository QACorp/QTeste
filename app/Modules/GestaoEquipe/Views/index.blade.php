@php
    use App\Modules\Retrabalhos\Contracts\Business\RetrabalhoBusinessContract;
    use App\Modules\Retrabalhos\Enums\PermissionEnum;
    use Illuminate\Support\Facades\Auth;
@endphp
@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)
@section('title', 'QTeste - Retrabalhos')

@section('content_header')
    <div class="row">
        <h1 class="m-0 text-dark col-md-8">Retrabalhos</h1>
        <div class="text-right col-md-4">
            @can(PermissionEnum::INSERIR_RETRABALHO->value)
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
                    Teste
                </div>
            </div>
        </div>
    </div>
@stop
