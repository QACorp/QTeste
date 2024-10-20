<?php

use App\Modules\GestaoEquipe\Submodules\Observacao\Controllers\API\ObservacaoController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => ''],function () {
    Route::get('/{idUsuario}', [ObservacaoController::class, 'lista']);
    Route::post('/{idUsuario}', [ObservacaoController::class, 'salvar']);
    Route::delete('/{idObservacao}', [ObservacaoController::class, 'remover']);
    Route::patch('/{idObservacao}', [ObservacaoController::class, 'alterar']);
//    Route::post('', [CheckpointController::class, 'salvar']);
});
