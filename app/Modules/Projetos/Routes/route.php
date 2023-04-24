<?php

use App\Modules\Projetos\Controllers\AplicacaoController;
use App\Modules\Projetos\Controllers\DocumentoController;
use Illuminate\Support\Facades\Route;
use App\Modules\Projetos\Controllers\ProjetoController;
use App\Modules\Projetos\Controllers\ObservacaoController;
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

    });
});

