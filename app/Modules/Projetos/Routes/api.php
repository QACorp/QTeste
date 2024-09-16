<?php

use App\Modules\Projetos\Controllers\API\AplicacaoController;
use App\Modules\Projetos\Controllers\API\ProjetoController;
use App\Modules\Projetos\Controllers\API\TarefaController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/'],function() {
    //Criar rota para listar projetos por equipe
    Route::get('/equipe/{idEquipe}', [ProjetoController::class,'listarProjetosPorEquipe']);
    Route::get('/equipe/{idEquipe}/aplicacao/{idAplicacao}', [ProjetoController::class,'listarProjetosPorAplicacao']);
    Route::get('/equipe/{idEquipe}/aplicacao/', [AplicacaoController::class,'listarAplicacoes']);
});

Route::group(['prefix' => '/tarefa'],function() {
    //Criar rota para listar projetos por equipe
    Route::get('/', [TarefaController::class,'listaTarefas']);
    Route::post('/', [TarefaController::class,'criarTarefa']);
    Route::put('/{tarefa}', [TarefaController::class,'alterarTarefa']);
    Route::get('/{tarefa}', [TarefaController::class,'buscarTarefa']);
});
