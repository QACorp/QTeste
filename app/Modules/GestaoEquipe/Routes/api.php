<?php

use App\Modules\GestaoEquipe\Controllers\Api\AlocacaoController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'alocacao'],function () {
    Route::get('/', [AlocacaoController::class, 'listarAlocacoes']);
    Route::get('/usuarios-disponiveis/{inicio}/{termino}', [AlocacaoController::class, 'usuariosDisponiveis']);
    Route::put('/{idAlocacao}', [AlocacaoController::class, 'alterarAlocacao']);
    Route::get('/{idAlocacao}', [AlocacaoController::class, 'consultarAlocacao']);
});
