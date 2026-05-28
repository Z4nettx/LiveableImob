<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('/', function () {
    return 'isso ta funcionando';
});
// rotas auth
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/admin/users', [UserController::class, 'listUsers'])->middleware('can:admin');

// rotas de imoveis
Route::resource('/properties', PropertyController::class)->only('index', 'show');
Route::resource('/properties', PropertyController::class)->only('edit', 'destroy')->middleware('auth:sanctum');
