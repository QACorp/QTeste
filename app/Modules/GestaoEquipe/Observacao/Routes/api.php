<?php

use App\Modules\GestaoEquipe\Alocacao\Controllers\Api\AlocacaoController;
use App\Modules\GestaoEquipe\Checkpoint\Controllers\API\CheckpointController;
use App\Modules\GestaoEquipe\Observacao\Controllers\API\ObservacaoController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => ''],function () {
    Route::get('/{idUsuario}', [ObservacaoController::class, 'lista']);
    Route::post('/{idUsuario}', [ObservacaoController::class, 'salvar']);
    Route::delete('/{idObservacao}', [ObservacaoController::class, 'remover']);
//    Route::post('', [CheckpointController::class, 'salvar']);
});
