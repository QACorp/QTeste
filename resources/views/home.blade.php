@extends('adminlte::page')

@section('title', 'QAKit')

@section('content_header')
    <h1 class="m-0 text-dark">QA Kit</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-4">
           <x-testes-mais-executados />
        </div>
    </div>

@stop
