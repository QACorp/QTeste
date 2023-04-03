<?php
use Illuminate\Support\Facades\Route;
use App\Modules\Projetos\Controllers\ProjetosController;

Route::get('/',[ProjetosController::class,'index'])->name('projetos.index');

