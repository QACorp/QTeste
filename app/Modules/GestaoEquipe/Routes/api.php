<?php

use App\Modules\GestaoEquipe\Alocacao\Controllers\Api\AlocacaoController;
use App\Modules\GestaoEquipe\Controllers\API\GestaoEquipeController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => ''],function () {
    Route::get('/{idUsuario}/registros', [GestaoEquipeController::class, 'buscarRegistros']);

});
