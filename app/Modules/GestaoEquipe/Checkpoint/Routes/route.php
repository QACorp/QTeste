<?php

use App\Modules\GestaoEquipe\Alocacao\Controllers\AlocacaoController;
use App\Modules\GestaoEquipe\Checkpoint\Controllers\CheckpointController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => ''],function () {
    Route::get('/', [CheckpointController::class, 'index'])->name('gestao-equipe.checkpoint.index');
});





