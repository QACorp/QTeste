<?php

use App\Modules\GestaoEquipe\Submodules\Checkpoint\Controllers\API\CheckpointController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => ''],function () {
    Route::get('', [CheckpointController::class, 'lista']);
    Route::post('', [CheckpointController::class, 'salvar']);
    Route::get('/usuarios', [CheckpointController::class, 'listaUsuarios']);
    Route::get('/projetos', [CheckpointController::class, 'listaProjetos']);
    Route::get('/alocacao/usuario/{idUsuario}/data/{data}', [CheckpointController::class, 'listaAlocacaoPorData']);
    Route::get('/usuario/{idUsuario}', [CheckpointController::class, 'listaCheckpointsPorUsuario']);
    Route::get('/ultimo/{idUsuario}', [CheckpointController::class, 'listaUltimoCheckpoint']);
    Route::get('/alocacao/{idAlocacao}', [CheckpointController::class, 'listarCheckpointPorAlocacao']);


});
