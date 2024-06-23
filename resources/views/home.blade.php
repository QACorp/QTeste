@php
    use App\System\Config\DashboardConfig;
@endphp
@extends('adminlte::page')

@section('title', 'QTeste')

@section('content_header')
    <h1 class="m-0 text-dark">QTeste</h1>
@stop

@section('content')
    <div class="">
        <div class="row">
            @foreach(DashboardConfig::getDashboardWidget() as $key => $widget)
                <div class="col-md-{{ $widget->getSize() }} col-12">
                    {!! Blade::render($widget->getComponente()) !!}
                </div>
            @endforeach
        </div>
    </div>

@stop
