@extends('adminlte::page')

@section('title', 'QAKit')

@section('content_header')
    <h1 class="m-0 text-dark">QA Kit</h1>
@stop

@section('content')
        @php
        $totalRegistroPorColuna = ceil(count(\App\System\Config\DashboardConfig::getDashboardWidget()) / 1)
        @endphp
        <div class="row">
            @php
                $totWidget = 0;
            @endphp
            @foreach(\App\System\Config\DashboardConfig::getDashboardWidget() as $key => $widget)
                @php
                    $totWidget += $widget->getSize()
                @endphp
                @if($totWidget >= 12 || $key == 0)

                    @if($key > 0)
                            </div>
                        </div>
                    @endif
                    <div class="col-12 px-0 mx-0">
                        <div class="row">
                    @php
                        $totWidget = 0;
                    @endphp
                @endif
                <div class="col-{{ $widget->getSize() }}">
                   {!! Blade::render($widget->getComponente()) !!}
                </div>

            @endforeach
            </div>
        </div>
    </div>

@stop
