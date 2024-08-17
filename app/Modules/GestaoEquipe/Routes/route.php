<?php

use App\Modules\GestaoEquipe\Controllers\AlocacaoController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'alocacacao'],function () {
    Route::get('/', [AlocacaoController::class, 'index'])->name('gestao-equipe.alocacoes.index');
});





