@php
    use App\Modules\Retrabalhos\Contracts\Business\RetrabalhoBusinessContract;
    use App\Modules\Retrabalhos\Enums\PermissionEnum;
    use Illuminate\Support\Facades\Auth;
@endphp
@extends('adminlte::page')

@section('title', 'QTeste - Relatórios')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)
@section('content_header')
    <div class="row">
        <h1 class="m-0 text-dark col-md-8">Relatórios</h1>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('relatorios.index')? 'active' : ''}} " {{ Route::is('relatorios.index')? 'aria-current="page"' : ''}} href="{{ route('relatorios.index') }}">Página inicial</a>
                        </li>
                        @can(\App\Modules\Retrabalhos\Enums\PermissionEnum::VER_RELATORIO_GESTOR->value)
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('relatorios.desenvolvedor')? 'active' : ''}} " {{ Route::is('relatorios.desenvolvedor')? 'aria-current="page"' : ''}} href="{{ route('relatorios.desenvolvedor') }}">Retr. por desenvolvedor</a>
                            </li>
                        @endcan
                        @can(\App\Modules\Retrabalhos\Enums\PermissionEnum::VER_RELATORIO_GESTOR->value)
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('relatorios.tarefas')? 'active' : ''}}" {{ Route::is('relatorios.tarefas')? 'aria-current="page"' : ''}} href="{{ route('relatorios.tarefas') }}">Retr. por tarefa</a>
                            </li>
                        @endcan
                        @can(\App\Modules\Retrabalhos\Enums\PermissionEnum::VER_RELATORIO_GESTOR->value)
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('relatorios.aplicacoes')? 'active' : ''}}" {{ Route::is('relatorios.aplicacoes')? 'aria-current="page"' : ''}} href="{{ route('relatorios.aplicacoes') }}">Retr. por aplicacao</a>
                            </li>
                        @endcan
                        @can(\App\Modules\Retrabalhos\Enums\PermissionEnum::VER_RELATORIO_DESENVOLVEDOR->value)
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('relatorios.meus-retrabalhos')? 'active' : ''}}" {{ Route::is('relatorios.meus-retrabalhos')? 'aria-current="page"' : ''}} href="{{ route('relatorios.meus-retrabalhos') }}">Meus retrabalhos</a>
                            </li>
                        @endcan
                        @can(\App\Modules\Retrabalhos\Enums\PermissionEnum::VER_RELATORIO_AUDITOR->value)
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('relatorios.meus-cadastros')? 'active' : ''}}" {{ Route::is('relatorios.meus-cadastros')? 'aria-current="page"' : ''}} href="{{ route('relatorios.meus-cadastros') }}">Meus cadastrados</a>
                            </li>
                        @endcan
                    </ul>
                    <div class="container">
                        @yield('relatorio-content')
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
