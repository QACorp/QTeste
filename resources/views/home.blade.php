@extends('adminlte::page')

@section('title', 'QAKit')

@section('content_header')
    <h1 class="m-0 text-dark">QA Kit</h1>
@stop

@section('content')
        <div class="d-flex flex-wrap flex-column flex-md-row">
            @foreach(\App\System\Config\DashboardConfig::getDashboardWidget() as $key => $widget)
                <div class="col-md-{{ $widget->getSize() }} col-12">
                   {!! Blade::render($widget->getComponente()) !!}
                </div>
            @endforeach
            </div>
        </div>
    </div>

@stop
