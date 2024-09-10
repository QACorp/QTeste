<?php

use App\Modules\Projetos\Controllers\API\AplicacaoController;
use App\Modules\Projetos\Controllers\API\ProjetoController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/'],function() {
    //Criar rota para listar projetos por equipe
    Route::get('/equipe/{idEquipe}', [ProjetoController::class,'listarProjetosPorEquipe']);
    Route::get('/equipe/{idEquipe}/aplicacao/{idAplicacao}', [ProjetoController::class,'listarProjetosPorAplicacao']);
    Route::get('/equipe/{idEquipe}/aplicacao/', [AplicacaoController::class,'listarAplicacoes']);
});
