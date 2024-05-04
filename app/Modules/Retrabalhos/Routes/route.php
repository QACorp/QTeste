<?php
use App\Modules\Retrabalhos\Controllers\ConsultaRetrabalhosController;
use App\Modules\Retrabalhos\Controllers\ConsultaUsuarioController;
use App\Modules\Retrabalhos\Controllers\DashboardController;
use App\Modules\Retrabalhos\Controllers\RelatorioController;
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
Route::group(['prefix' => 'relatorios'],function () {
    Route::get('/', [RelatorioController::class, 'index'])->name('relatorios.index');
    Route::get('/desenvolvedores', [RelatorioController::class, 'porDesenvolvedor'])->name('relatorios.desenvolvedor');
    Route::get('/tarefas', [RelatorioController::class, 'porTarefa'])->name('relatorios.tarefas');
    Route::get('/aplicacoes', [RelatorioController::class, 'index'])->name('relatorios.aplicacoes');
    Route::get('/meus-retrabalhos', [RelatorioController::class, 'index'])->name('relatorios.meus-retrabalhos');
    Route::get('/meus-cadastros', [RelatorioController::class, 'index'])->name('relatorios.meus-cadastros');


});
//Route::get('/',[GantController::class,'index'])->name('gestao-projetos.index');





