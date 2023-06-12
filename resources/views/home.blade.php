@extends('adminlte::page')

@section('title', 'QAKit')

@section('content_header')
    <h1 class="m-0 text-dark">QA Kit</h1>
@stop

@section('content')
        @php
        $totalRegistroPorColuna = ceil(count(\App\System\Config\DashboardConfig::getDashboardWidget()) / 3)
        @endphp
        <div class="row">
            @foreach(\App\System\Config\DashboardConfig::getDashboardWidget() as $key => $widget)
                @if($key % $totalRegistroPorColuna == 0 || $key == 0)
                    @if($key > 0)
                        </div>
                    @endif
                    <div class="col-4 px-0 mx-0">
                @endif
                <div class="col-12">
                   {!! Blade::render($widget->getComponente()) !!}
                </div>
            @endforeach
            </div>
        </div>
    </div>

@stop
