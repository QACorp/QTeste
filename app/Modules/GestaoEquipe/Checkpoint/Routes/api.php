<?php

use App\Modules\GestaoEquipe\Alocacao\Controllers\Api\AlocacaoController;
use App\Modules\GestaoEquipe\Checkpoint\Controllers\API\CheckpointController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => ''],function () {
    Route::get('', [CheckpointController::class, 'lista']);
    Route::get('/usuarios', [CheckpointController::class, 'listaUsuarios']);
    Route::get('/ultimo/{idUsuario}', [CheckpointController::class, 'listaUltimoCheckpoint']);
    Route::get('/projetos', [CheckpointController::class, 'listaProjetos']);
    Route::get('/alocacao/usuario/{idUsuario}/data/{data}', [CheckpointController::class, 'listaAlocacaoPorUsuario']);
});
