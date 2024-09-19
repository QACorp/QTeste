<?php

use App\Modules\GestaoEquipe\Alocacao\Controllers\AlocacaoController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '', 'middleware' => 'vue'],function () {
    Route::get('/', [AlocacaoController::class, 'index'])->name('gestao-equipe.alocacoes.index');
});





