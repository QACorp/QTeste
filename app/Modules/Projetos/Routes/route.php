<?php

use App\Modules\Projetos\Controllers\AplicacaoController;
use App\Modules\Projetos\Controllers\CasoTesteController;
use App\Modules\Projetos\Controllers\ConsultaAplicacaoController;
use App\Modules\Projetos\Controllers\ConsultaCasoTesteController;
use App\Modules\Projetos\Controllers\ConsultaProjetoController;
use App\Modules\Projetos\Controllers\DocumentoController;
use App\Modules\Projetos\Controllers\PlanoTesteController;
use App\Modules\Projetos\Controllers\PlanoTesteExecucaoController;
use App\Modules\Projetos\Controllers\QAraController;
use Illuminate\Support\Facades\Route;
use App\Modules\Projetos\Controllers\ProjetoController;
use App\Modules\Projetos\Controllers\ObservacaoController;
use App\Modules\Projetos\Controllers\UploadCasosTesteController;

Route::get('/',[ProjetoController::class,'index'])->name('projetos.index');

Route::group(['prefix' => 'aplicacoes'],function(){
    Route::get('/',[AplicacaoController::class,'index'])->name('aplicacoes.index');

    Route::get('/inserir',[AplicacaoController::class,'inserir'])->name('aplicacoes.inserir');
    Route::get('/editar/{id}',[AplicacaoController::class,'editar'])->name('aplicacoes.editar');

    Route::put('/editar/{id}',[AplicacaoController::class,'atualizar'])->name('aplicacoes.atualizar');
    Route::post('/inserir',[AplicacaoController::class,'salvar'])->name('aplicacoes.salvar');
    Route::delete('/exluir/{id}',[AplicacaoController::class,'excluir'])->name('aplicacoes.excluir');


    Route::group(['prefix' => '{idAplicacao}/projetos'],function(){
        Route::get('/',[ProjetoController::class,'index'])->name('aplicacoes.projetos.index');
        Route::get('/inserir',[ProjetoController::class,'inserir'])->name('aplicacoes.projetos.inserir');
        Route::get('/{idProjeto}/editar',[ProjetoController::class,'editar'])->name('aplicacoes.projetos.editar');

        Route::put('/{idProjeto}/editar',[ProjetoController::class,'atualizar'])->name('aplicacoes.projetos.atualizar');
        Route::post('/inserir',[ProjetoController::class,'salvar'])->name('aplicacoes.projetos.salvar');

        Route::post('{idProjeto}/observacao/inserir',[ObservacaoController::class,'salvar'])->name('aplicacoes.projetos.observacao.salvar');
        Route::post('{idProjeto}/documento/inserir',[DocumentoController::class,'salvar'])->name('aplicacoes.projetos.documento.salvar');

        Route::delete('/{idProjeto}/excluir',[ProjetoController::class,'excluir'])->name('aplicacoes.projetos.excluir');
        Route::delete('/{idProjeto}/documento/{idDocumento}/excluir',[DocumentoController::class,'excluir'])->name('aplicacoes.projetos.documento.excluir');

        Route::group(['prefix' => '/{idProjeto}/planos-teste'],function() {
            Route::get('/', [PlanoTesteController::class, 'indexPorProjeto'])->name('aplicacoes.projetos.planos-teste.index');
            Route::get('/inserir', [PlanoTesteController::class, 'inserir'])->name('aplicacoes.projetos.planos-teste.inserir');
            Route::get('/{idPlanoTeste}/visualizar', [PlanoTesteController::class, 'visualizar'])->name('aplicacoes.projetos.planos-teste.visualizar');

            Route::post('/inserir', [PlanoTesteController::class, 'salvar'])->name('aplicacoes.projetos.planos-teste.salvar');
            Route::delete('/{idPlanoTeste}/excluir',[PlanoTesteController::class,'excluir'])->name('aplicacoes.projetos.planos-teste.excluir');
            Route::put('/{idPlanoTeste}/alterar', [PlanoTesteController::class, 'alterar'])->name('aplicacoes.projetos.planos-teste.alterar');
            Route::get('/{idPlanoTeste}/executar', [PlanoTesteExecucaoController::class, 'executar'])->name('aplicacoes.projetos.planos-teste.executar');
            Route::get('/{idPlanoTeste}/criar', [PlanoTesteExecucaoController::class, 'criar'])->name('aplicacoes.projetos.planos-teste.criar');

            Route::post('/{idPlanoTeste}/execucao/{idPlanoTesteExecucao}/finalizar', [PlanoTesteExecucaoController::class, 'finalizar'])->name('aplicacoes.projetos.planos-teste.finalizar');
            Route::get('/{idPlanoTeste}/plano-teste-execucao/{idPlanoTesteExecucao}/executar', [PlanoTesteExecucaoController::class, 'executarGeral'])->name('aplicacoes.projetos.planos-teste-execucao.visualizar');

            Route::post('/{idPlanoTeste}/executar/{idPlanoTesteExecucao}/{idCasoTeste}', [PlanoTesteExecucaoController::class, 'executarCasoTeste'])->name('aplicacoes.projetos.planos-teste.executar-caso-teste');


            Route::group(['prefix' => '/{idPlanoTeste}/casos-teste'],function() {
                Route::post('/vincular', [CasoTesteController::class, 'vincular'])->name('aplicacoes.projetos.planos-teste.casos-teste.vincular');
                Route::post('/inserir', [CasoTesteController::class, 'inserirEVincular'])->name('aplicacoes.projetos.planos-teste.casos-teste.inserir');
                Route::delete('/desvincular/{idCasoTeste}', [CasoTesteController::class, 'desvincular'])->name('aplicacoes.projetos.planos-teste.casos-teste.desvincular');

                Route::post('/import-file', [UploadCasosTesteController::class, 'uploadArquivoExcelParaPlanoTeste'])->name('aplicacoes.planos-teste.upload-caso-teste');

            });
        });

    });

});
Route::group(['prefix' => '/casos-teste'],function() {
    Route::group(['prefix' => '/qara'],function() {
        Route::get('/', [QAraController::class, 'index'])->name('caso-teste.qara.index');
        Route::post('/gerar-texto', [QAraController::class, 'gerarTexto'])->name('caso-teste.qara.gerar-texto');
    });

    Route::get('/', [CasoTesteController::class, 'index'])->name('aplicacoes.casos-teste.index');
    Route::get('/list',[CasoTesteController::class,'list'])->name('aplicacoes.casos-teste.list');

    Route::post('/import-file', [UploadCasosTesteController::class, 'uploadArquivoExcel'])->name('aplicacoes.casos-teste.upload-caso-teste');

    Route::get('/inserir', [CasoTesteController::class, 'inserir'])->name('aplicacoes.casos-teste.inserir');
    Route::get('/{idCasoTeste}', [CasoTesteController::class, 'editar'])->name('aplicacoes.casos-teste.editar');

    Route::post('/inserir', [CasoTesteController::class, 'salvar'])->name('aplicacoes.casos-teste.salvar');
    Route::put('/{idCasoTeste}', [CasoTesteController::class, 'atualizar'])->name('aplicacoes.casos-teste.atualizar');
    Route::delete('/{idCasoTeste}', [CasoTesteController::class, 'excluir'])->name('aplicacoes.casos-teste.excluir');


});

Route::group(['prefix' => '/planos-teste'],function() {
    Route::get('/', [PlanoTesteController::class, 'index'])->name('aplicacoes.planos-teste.index');

});
Route::group(['prefix' => '/consultas'],function() {
    Route::get('/aplicacoes', [ConsultaAplicacaoController::class, 'getAplicacao'])->name('aplicacoes.consulta.index');
    Route::get('/aplicacoes/{idAplicacao}/projetos', [ConsultaProjetoController::class, 'getProjetosByAplicacao'])->name('aplicacoes.projetos.consulta.index');
    Route::get('/casos-testes', [ConsultaCasoTesteController::class, 'getCasosTeste'])->name('casos-testes.consulta.index');
    Route::get('/casos-testes/{idCasoTeste}', [ConsultaCasoTesteController::class, 'getCasosTestePorId'])->name('casos-testes.consultaPorId.index');

});

