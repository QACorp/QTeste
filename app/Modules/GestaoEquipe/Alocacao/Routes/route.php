<?php

use App\Modules\GestaoEquipe\Alocacao\Controllers\AlocacaoController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => ''],function () {
    Route::get('/', [AlocacaoController::class, 'index'])->name('gestao-equipe.alocacoes.index');
});





