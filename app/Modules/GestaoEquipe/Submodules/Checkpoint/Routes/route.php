<?php

use App\Modules\GestaoEquipe\Submodules\Checkpoint\Controllers\CheckpointController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '', 'middleware' => 'vue'],function () {
    Route::get('/', [CheckpointController::class, 'index'])->name('gestao-equipe.checkpoint.index');
});





