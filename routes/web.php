<?php

use Illuminate\Support\Facades\Route;
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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/home', [App\System\Http\Controllers\HomeController::class, 'index'])->name('home');

// Authentication Routes...
Route::get('login', 'App\System\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'App\System\Http\Controllers\Auth\LoginController@login');
Route::get('logout', 'App\System\Http\Controllers\Auth\LoginController@logout');

// Registration Routes...
Route::get('register', 'App\System\Http\Controllers\Auth\RegisterController@showRegistrationForm');
Route::post('register', 'App\System\Http\Controllers\Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset/{token?}', 'App\System\Http\Controllers\Auth\ResetPasswordController@showResetForm');
Route::post('password/email', 'App\System\Http\Controllers\Auth\ResetPasswordController@sendResetLinkEmail');
Route::post('password/reset', 'App\System\Http\Controllers\Auth\ResetPasswordController@reset');

//Route::get('teste',[\App\Modules\Example\Controller\ExampleController::class,'myMethod'])->middleware('auth');
Route::get('/home', function() {
    return view('home');
})->name('home')->middleware('auth');


