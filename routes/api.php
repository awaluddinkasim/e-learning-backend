<?php

use App\Http\Controllers\Admin\ChatController;
use App\Http\Controllers\API\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\Dosen\DosenController;
use App\Http\Controllers\Twilio\AccessTokenController;
use App\Http\Controllers\User\UserController;

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
    // kelas
    Route::post('/enroll', [UserController::class, 'enroll']);
    Route::get('/kelas/{userID}', [UserController::class, 'getKelas']);
    Route::get('/kelas/data/{kode}', [DosenController::class, 'getDataKelas']);

    // logout
    Route::get('/logout', [AuthController::class, 'logout']);
});




Route::group(['middleware' => 'auth:dosen', 'prefix' => 'dosen'], function () {
    // kelas
    Route::get('/kelas/{dosenID}', [DosenController::class, 'getKelas']);
    Route::get('/kelas/data/{kode}', [DosenController::class, 'getDataKelas']);
    Route::post('/kelas', [DosenController::class, 'buatKelas']);

    // tugas
    Route::post('/tugas', [DosenController::class, 'uploadTugas']);


    // materi
    Route::get('/materi/{kode}', [DosenController::class, 'getMateri']);
    Route::post('/materi', [DosenController::class, 'uploadMateri']);

    // kuis
    Route::get('/kuis/{kode}', [DosenController::class, 'getKuis']);
    Route::post('/kuis', [DosenController::class, 'uploadKuis']);

    // logout
    Route::get('/logout', [AuthController::class, 'logout']);
});

Route::group(['middleware' => 'auth:admin', 'prefix' => 'admin'], function () {
    // users
    Route::post('/create/{tipe}', [AdminController::class, 'createUser']);
    Route::get('/users/{tipe}', [AdminController::class, 'getUsers']);
    Route::put('/user/{tipe}/{id}', [AdminController::class, 'updateUser']);
    Route::delete('/user/{tipe}/{id}', [AdminController::class, 'deleteUser']);

    Route::get('/logout', [AuthController::class, 'logout']);
});

Route::get('access_token', [AccessTokenController::class, 'generate_token']);


Route::post('/login', [AuthController::class, 'loginUser']);
Route::post('/dosen/login', [AuthController::class, 'loginDosen']);
Route::post('/admin/login', [AuthController::class, 'loginAdmin']);
