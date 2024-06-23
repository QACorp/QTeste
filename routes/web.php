<?php

use App\System\Http\Controllers\EmpresaController;
use App\System\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\System\Http\Controllers\UserController;
use App\System\Http\Controllers\EquipeController;
use App\System\Http\Controllers\UploadUsersController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [App\System\Http\Controllers\HomeController::class, 'index'])->name('home');

// Authentication Routes...
Route::get('login', 'App\System\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'App\System\Http\Controllers\Auth\LoginController@login');
Route::post('logout', 'App\System\Http\Controllers\Auth\LoginController@logout');
Route::group(['middleware' => 'auth'],function() {
    Route::get('/alterar-senha', [UserController::class,'editarSenhaUsuarioLogado'])->name('users.alterar-senha-usuario-logado');
    Route::get('/alterar-empresa', [EmpresaController::class,'editar'])->name('users.alterar-empresa');
    Route::put('/alterar-empresa', [EmpresaController::class,'atualizar'])->name('users.atualizar-empresa');
    Route::put('/alterar-senha', [UserController::class,'atualizarSenhaUsuarioLogado'])->name('users.atualizar-senha-usuario-logado');

});



Route::group(['prefix' => 'usuarios', 'middleware' => 'auth'],function(){
    Route::get('/', [UserController::class,'index'])->name('users.index');
    Route::get('/inserir', [UserController::class,'inserir'])->name('users.inserir');
    Route::post('/inserir/importar', [UploadUsersController::class,'uploadArquivoExcelParaUsers'])->name('users.upload');

    Route::get('/{idUsuario}', [UserController::class,'editar'])->name('users.editar');
    Route::get('/{idUsuario}/alterar-senha', [UserController::class,'editarSenha'])->name('users.alterar-senha');

    Route::put('/{idUsuario}/alterar-senha', [UserController::class,'atualizarSenha'])->name('users.atualizar-senha');
    Route::post('/inserir', [UserController::class,'salvar'])->name('users.salvar');
    Route::put('/{idUsuario}', [UserController::class,'atualizar'])->name('users.atualizar');


});

Route::group(['prefix' => 'equipes', 'middleware' => 'auth'],function(){
    Route::get('/', [EquipeController::class,'index'])->name('equipes.index');
    Route::get('/inserir', [EquipeController::class,'inserir'])->name('equipes.inserir');
//
    Route::get('/{idEquipe}', [EquipeController::class,'editar'])->name('equipes.editar');
//    Route::get('/{idUsuario}/alterar-senha', [UserController::class,'editarSenha'])->name('users.alterar-senha');
//
    Route::get('/selecionar-equipe/{idEquipe}', [UserController::class,'alterarEquipeCookie'])->name('users.atualizar-equipe');
    Route::post('/inserir', [EquipeController::class,'salvar'])->name('equipes.salvar');
    Route::put('/{idUsuario}', [EquipeController::class,'atualizar'])->name('equipes.atualizar');
});

Route::get('/home', [HomeController::class,'index'])->name('home.index')->middleware(['auth']);


