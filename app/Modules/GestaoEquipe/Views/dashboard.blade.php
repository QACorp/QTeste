@php
    use App\Modules\GestaoEquipe\Alocacao\Enums\PermissionEnum;
    use App\Modules\GestaoEquipe\Checkpoint\Enums\PermissionEnum as CheckpointPermissionEnum;
@endphp
@extends('adminlte::page')

@section('title', 'QTeste - Alocações')

@section('content_header')
    <div class="row">
        <h1 class="m-0 text-dark col-md-8">Dashboard - {{ $usuario->name }}</h1>

    </div>
@stop

@section('content')
    <painel :id-usuario="{{ $usuario->id }}" />
@stop
