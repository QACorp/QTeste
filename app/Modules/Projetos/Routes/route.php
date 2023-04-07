<?php

use App\Modules\Projetos\Controllers\AplicacaoController;
use Illuminate\Support\Facades\Route;
use App\Modules\Projetos\Controllers\ProjetosController;

Route::get('/',[ProjetosController::class,'index'])->name('projetos.index');

Route::group(['prefix' => 'aplicacoes'],function(){
    Route::get('/',[AplicacaoController::class,'index'])->name('aplicacoes.index');
    Route::get('/inserir',[AplicacaoController::class,'inserir'])->name('aplicacoes.inserir');

    Route::post('/inserir',[AplicacaoController::class,'salvar'])->name('aplicacoes.salvar');
});

