<?php


use App\Modules\Retrabalhos\Controllers\RetrabalhosController;
use Illuminate\Support\Facades\Route;
Route::group(['prefix' => ''],function () {
    Route::get('/', [RetrabalhosController::class, 'index'])->name('retrabalhos.index');

    });

//Route::get('/',[GantController::class,'index'])->name('gestao-projetos.index');





