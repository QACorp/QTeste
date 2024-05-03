<?php
use App\Modules\Retrabalhos\Controllers\ConsultaRetrabalhosController;
use App\Modules\Retrabalhos\Controllers\ConsultaUsuarioController;
use App\Modules\Retrabalhos\Controllers\DashboardController;
use App\Modules\Retrabalhos\Controllers\RetrabalhosController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => ''],function () {
    Route::get('/', [RetrabalhosController::class, 'index'])->name('retrabalhos.index');
    Route::get('/inserir', [RetrabalhosController::class, 'inserir'])->name('retrabalhos.inserir');
    Route::get('/show/{idRetrabalho}', [RetrabalhosController::class, 'mostrarProvidencia'])->name('retrabalhos.providencia.index');
    Route::get('/alterar/{idRetrabalho}', [RetrabalhosController::class, 'alterar'])->name('retrabalhos.alterar.index');
    Route::put('/alterar/{idRetrabalho}', [RetrabalhosController::class, 'editar'])->name('retrabalhos.editar');
    Route::post('/inserir', [RetrabalhosController::class, 'salvar'])->name('retrabalhos.salvar');
    Route::delete('/remover/{idRetrabalho}', [RetrabalhosController::class, 'excluir'])->name('retrabalhos.remover');

});
Route::group(['prefix' => 'consultas'],function () {
    Route::get('/tipos', [ConsultaRetrabalhosController::class, 'getTipos'])->name('retrabalhos.tipos.index');
    Route::get('/usuarios', [ConsultaUsuarioController::class, 'getUsuarios'])->name('retrabalhos.usuarios.index');

});
Route::group(['prefix' => 'dashboard'],function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

});
//Route::get('/',[GantController::class,'index'])->name('gestao-projetos.index');





