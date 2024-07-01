@extends('adminlte::page')
@section('plugins.Select2', true)
@section('title', 'QTeste - Configurações')
@section('content_header')
    <h1 class="m-0 text-dark">Configurações </h1>

@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('configuracao.salvar') }}">
                        @csrf
                        <h2>Configuração de envio de e-mail</h2>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <x-adminlte-input
                                        name="MAIL_MAILER"
                                        label="Mail Mailer"
                                        placeholder="smtp"
                                        fgroup-class="col-md-12"
                                        value="{{ $configuracoes->where('nome','MAIL_MAILER')->first()?->valor }}"
                                        required
                                    />
                                </div>
                                <div class="row">
                                    <x-adminlte-input
                                        name="MAIL_HOST"
                                        label="Mail host"
                                        placeholder="mailhog"
                                        fgroup-class="col-md-12"
                                        value="{{ $configuracoes->where('nome','MAIL_HOST')->first()?->valor }}"
                                        required
                                    />
                                </div>
                                <div class="row">
                                    <x-adminlte-input
                                        name="MAIL_PORT"
                                        label="Mail port"
                                        placeholder="1025"
                                        fgroup-class="col-md-12"
                                        value="{{ $configuracoes->where('nome','MAIL_PORT')->first()?->valor }}"
                                        required
                                    />
                                </div>
                                <div class="row">
                                    <x-adminlte-input
                                        name="MAIL_USERNAME"
                                        label="Mail username"
                                        placeholder=""
                                        fgroup-class="col-md-12"
                                        value="{{ $configuracoes->where('nome','MAIL_USERNAME')->first()?->valor }}"
                                        required
                                    />
                                </div>
                                <div class="row">
                                    <x-adminlte-input
                                        name="MAIL_PASSWORD"
                                        label="Mail password"
                                        placeholder=""
                                        type="password"
                                        fgroup-class="col-md-12"
                                        value="{{ $configuracoes->where('nome','MAIL_PASSWORD')->first()?->valor }}"
                                        required
                                    />
                                </div>
                                <div class="row">
                                    <x-adminlte-input
                                        name="MAIL_ENCRYPTION"
                                        label="Mail encryption"
                                        placeholder=""
                                        fgroup-class="col-md-12"
                                        value="{{ $configuracoes->where('nome','MAIL_ENCRYPTION')->first()?->valor }}"
                                        required
                                    />
                                </div>
                                <div class="row">
                                    <x-adminlte-input
                                        name="MAIL_FROM_ADDRESS"
                                        label="Mail from"
                                        placeholder="hello@example.com"
                                        fgroup-class="col-md-12"
                                        value="{{ $configuracoes->where('nome','MAIL_FROM_ADDRESS')->first()?->valor }}"
                                        required
                                    />
                                </div>
                                <div class="row">
                                    <x-adminlte-input
                                        name="MAIL_FROM_NAME"
                                        label="Mail from name"
                                        placeholder="noreply"
                                        fgroup-class="col-md-12"
                                        value="{{ $configuracoes->where('nome','MAIL_FROM_NAME')->first()?->valor }}"
                                        required
                                    />
                                </div>


                            </div>
                            <div class="col-md-6 border-2 border-left pl-4">

                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <x-adminlte-button
                                    label="Salvar"
                                    theme="success"
                                    icon="fas fa-save"
                                    type="submit"
                                />
                                <a href="{{ route('home') }}"
                                   class="btn btn-primary ml-1"
                                ><i class="fas fa-undo"></i> Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

