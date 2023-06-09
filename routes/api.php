<?php

use App\Http\Controllers\AuthController;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/user', [AuthController::class, 'getUsers']);
    Route::post('/auth/logOut', [AuthController::class, 'logOut']);
    Route::get('/auth/checkLogin', [AuthController::class, 'checkLogin']);
});

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/signup', [AuthController::class, 'saveUserInfo']);
Route::get('/ilkin', [AuthController::class, 'ilkin']);
