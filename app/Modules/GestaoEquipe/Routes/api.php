<?php

use App\Modules\GestaoEquipe\Controllers\Api\AlocacaoController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'alocacao'],function () {
    Route::get('/', [AlocacaoController::class, 'listarAlocacoes']);
    Route::put('/{idAlocacao}', [AlocacaoController::class, 'alterarAlocacao']);
});
