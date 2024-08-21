<?php

use App\Modules\GestaoEquipe\Alocacao\Controllers\Api\AlocacaoController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'alocacao'],function () {
    Route::get('/', [AlocacaoController::class, 'listarAlocacoes']);
    Route::get('/minha', [AlocacaoController::class, 'listarMinhasAlocacoes']);
    Route::post('/', [AlocacaoController::class, 'criarAlocacao']);
    Route::get('/usuarios-disponiveis/{inicio}/{termino}', [AlocacaoController::class, 'usuariosDisponiveis']);
    Route::get('/projetos-disponiveis/{inicio}/{termino}', [AlocacaoController::class, 'projetosDisponiveis']);
    Route::put('/{idAlocacao}', [AlocacaoController::class, 'alterarAlocacao']);
    Route::get('/{idAlocacao}', [AlocacaoController::class, 'consultarAlocacao']);
    Route::patch('/{idAlocacao}/concluir', [AlocacaoController::class, 'marcarAlocacaoComoConcluida']);
});
