<?php

use App\Modules\GestaoEquipe\Alocacao\Controllers\AlocacaoController;
use App\Modules\GestaoEquipe\Controllers\GestaoEquipeController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '', 'middleware' => 'vue'],function () {
    Route::get('/{idUsuario}', [GestaoEquipeController::class, 'dashboard'])->name('gestao-equipe.index');
});





