<?php
use App\Modules\Retrabalhos\Controllers\ConsultaRetrabalhosController;
use App\Modules\Retrabalhos\Controllers\ConsultaUsuarioController;
use App\Modules\Retrabalhos\Controllers\RetrabalhosController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => ''],function () {
    Route::get('/', [RetrabalhosController::class, 'index'])->name('retrabalhos.index');
    Route::get('/inserir', [RetrabalhosController::class, 'inserir'])->name('retrabalhos.inserir');
    Route::post('/inserir', [RetrabalhosController::class, 'salvar'])->name('retrabalhos.salvar');

});
Route::group(['prefix' => 'consultas'],function () {
    Route::get('/tipos', [ConsultaRetrabalhosController::class, 'getTipos'])->name('retrabalhos.tipos.index');
    Route::get('/usuarios', [ConsultaUsuarioController::class, 'getUsuarios'])->name('retrabalhos.usuarios.index');

});
//Route::get('/',[GantController::class,'index'])->name('gestao-projetos.index');





