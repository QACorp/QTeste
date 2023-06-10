@extends('adminlte::page')

@section('title', 'QAKit')

@section('content_header')
    <h1 class="m-0 text-dark">QA Kit</h1>
@stop

@section('content')
    <div class="row">
        @foreach(\App\System\Config\DashboardConfig::getDashboardWidget() as $widget)
        <div class="col-4">
           {!! Blade::render($widget->getComponente()) !!}
        </div>
        @endforeach
    </div>

@stop
