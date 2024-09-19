<?php

use App\Modules\Retrabalhos\Controllers\API\RetrabalhosController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'criticidade'],function () {
    Route::get('/', [RetrabalhosController::class, 'listarCriticidade']);
});
Route::group(['prefix' => ''],function () {
    Route::post('/', [RetrabalhosController::class, 'inserirRetrabalho']);
    Route::get('/meus', [RetrabalhosController::class, 'listarRetrabalhosPorUsuarioLogado']);
    Route::get('/equipe/{idEquipe}', [RetrabalhosController::class, 'listarRetrabalhos']);
    Route::put('/{idRetrabalho}', [RetrabalhosController::class, 'alterarRetrabalho']);
    Route::delete('/{idRetrabalho}', [RetrabalhosController::class, 'excluirRetrabalho']);
    Route::get('/{idRetrabalho}', [RetrabalhosController::class, 'buscarRetrabalho']);
});

