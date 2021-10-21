<?php

use App\Http\Controllers\API\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\Twilio\AccessTokenController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['middleware' => 'auth:user'], function () {
    Route::get('/logout', [AuthController::class, 'logout']);
});

Route::group(['middleware' => 'auth:dosen', 'prefix' => 'dosen'], function () {
    Route::get('/logout', [AuthController::class, 'logout']);
});

Route::group(['middleware' => 'auth:admin', 'prefix' => 'admin'], function () {
    // users
    Route::post('/create/{tipe}', [AdminController::class, 'createUser']);
    Route::get('/users/{tipe}', [AdminController::class, 'getUsers']);
    Route::put('/user/{tipe}/{id}', [AdminController::class, 'updateUser']);
    Route::delete('/user/{tipe}/{id}', [AdminController::class, 'deleteUser']);

    // chat

    Route::get('/logout', [AuthController::class, 'logout']);
});

Route::get('access_token', [AccessTokenController::class, 'generate_token']);


Route::post('/login', [AuthController::class, 'loginUser']);
Route::post('/dosen/login', [AuthController::class, 'loginDosen']);
Route::post('/admin/login', [AuthController::class, 'loginAdmin']);
