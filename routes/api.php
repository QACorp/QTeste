<?php

use App\System\Http\Controllers\API\UserController;
use App\System\Http\Controllers\AuthApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {

    Route::post('login', [AuthApiController::class, 'login']);
    Route::post('logout', [AuthApiController::class, 'logout']);
    Route::post('refresh', [AuthApiController::class,'refresh']);
    Route::post('me', [AuthApiController::class, 'me']);

});
Route::group(['middleware' => ['api', 'auth:api'], 'prefix' => 'user'], function () {
    Route::get('/equipe/{idEquipe}', [UserController::class, 'getUserByEquipe']);
    Route::get('/permissoes', [UserController::class, 'getPermissions']);
});
