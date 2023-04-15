<?php

use App\Modules\Projetos\Controllers\AplicacaoController;
use Illuminate\Support\Facades\Route;
use App\Modules\Projetos\Controllers\ProjetoController;

Route::get('/',[ProjetoController::class,'index'])->name('projetos.index');

Route::group(['prefix' => 'aplicacoes'],function(){
    Route::get('/',[AplicacaoController::class,'index'])->name('aplicacoes.index');
    Route::get('/inserir',[AplicacaoController::class,'inserir'])->name('aplicacoes.inserir');
    Route::get('/editar/{id}',[AplicacaoController::class,'editar'])->name('aplicacoes.editar');

    Route::put('/editar/{id}',[AplicacaoController::class,'atualizar'])->name('aplicacoes.atualizar');
    Route::post('/inserir',[AplicacaoController::class,'salvar'])->name('aplicacoes.salvar');
    Route::delete('/exluir/{id}',[AplicacaoController::class,'excluir'])->name('aplicacoes.excluir');
    Route::group(['prefix' => '{id}/projetos'],function(){
        Route::get('/',[ProjetoController::class,'index'])->name('aplicacoes.projetos.index');
    });
});

