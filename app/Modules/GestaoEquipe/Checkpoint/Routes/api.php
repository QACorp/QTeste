<?php

use App\Modules\GestaoEquipe\Alocacao\Controllers\Api\AlocacaoController;
use App\Modules\GestaoEquipe\Checkpoint\Controllers\API\CheckpointController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => ''],function () {
    Route::get('', [CheckpointController::class, 'lista']);
});
