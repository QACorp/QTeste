<?php

use App\Modules\Projetos\Controllers\AplicacaoController;
use App\Modules\Projetos\Controllers\CasoTesteController;
use App\Modules\Projetos\Controllers\ConsultaAplicacaoController;
use App\Modules\Projetos\Controllers\ConsultaCasoTesteController;
use App\Modules\Projetos\Controllers\ConsultaProjetoController;
use App\Modules\Projetos\Controllers\DocumentoController;
use App\Modules\Projetos\Controllers\ObservacaoController;
use App\Modules\Projetos\Controllers\PlanoTesteController;
use App\Modules\Projetos\Controllers\PlanoTesteExecucaoController;
use App\Modules\Projetos\Controllers\ProjetoController;
use App\Modules\Projetos\Controllers\UploadCasosTesteController;
use App\Modules\QAra\Controllers\QAraController;
use Illuminate\Support\Facades\Route;

Route::get('/',[ProjetoController::class,'index'])->name('projetos.index');


Route::group(['prefix' => '/casos-teste'],function() {
    Route::group(['prefix' => '/'],function() {
        Route::get('/', [QAraController::class, 'index'])->name('caso-teste.qara.index');
        Route::post('/gerar-texto', [QAraController::class, 'gerarTexto'])->name('caso-teste.qara.gerar-texto');
    });

});


