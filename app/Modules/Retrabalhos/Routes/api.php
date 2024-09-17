<?php

use App\Modules\Retrabalhos\Controllers\API\RetrabalhosController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => ''],function () {
    Route::post('/', [RetrabalhosController::class, 'inserirRetrabalho']);
    Route::get('/equipe/{idEquipe}', [RetrabalhosController::class, 'listarRetrabalhos']);
});
