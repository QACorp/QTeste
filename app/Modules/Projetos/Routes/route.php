<?php

use App\Modules\Projetos\Controllers\AplicacaoController;
use Illuminate\Support\Facades\Route;
use App\Modules\Projetos\Controllers\ProjetosController;

Route::get('/',[ProjetosController::class,'index'])->name('projetos.index');

Route::get('/aplicacoes',[AplicacaoController::class,'index'])->name('aplicacoes.index');
Route::get('/aplicacoes/inserir',[AplicacaoController::class,'index'])->name('aplicacoes.inserir');
