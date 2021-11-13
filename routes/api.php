<?php

use App\Http\Controllers\API\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\DosenController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\Twilio\AccessTokenController;
use App\Models\Kuis;
use App\Models\KuisTerkumpul;
use App\Models\Materi;
use App\Models\TugasMasuk;

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
    Route::get('/kelas/data/{kode}', [UserController::class, 'getDataKelas']);

    // materi
    Route::get('/materi/{kode}', [UserController::class, 'getMateri']);

    // tugas
    Route::get('/tugas/{kode}', [UserController::class, 'getTugas']);
    Route::get('/tugas/{kode}/{id}', [UserController::class, 'getDetailTugas']);
    Route::get('/tugas/{kode}/{id}/{uploader}', [UserController::class, 'cekTugas']);
    Route::post('/tugas/{kode}/{id}', [UserController::class, 'uploadTugas']);

    // kuis
    Route::get('/kuis/{kode}', [UserController::class, 'getKuis']);
    Route::get('/kuis/{kode}/{id}', [UserController::class, 'getDetailKuis']);
    Route::get('/kuis/{kode}/{id}/{uploader}', [UserController::class, 'cekKuis']);
    Route::post('/kuis/{kode}/{id}', [UserController::class, 'kumpulKuis']);


    Route::post('/profile', [UserController::class, 'updateProfile']);

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
    Route::get('/tugas-masuk/{kode}/{id}', [DosenController::class, 'getTugasMasuk']);


    // materi
    Route::get('/materi/{kode}', [DosenController::class, 'getMateri']);
    Route::post('/materi', [DosenController::class, 'uploadMateri']);

    // kuis
    Route::get('/kuis/{kode}', [DosenController::class, 'getKuis']);
    Route::post('/kuis', [DosenController::class, 'uploadKuis']);
    Route::get('/kuis/{kode}/{id}', [DosenController::class, 'getKuisMasuk']);

    Route::post('/profile', [DosenController::class, 'updateProfile']);
    // logout
    Route::get('/logout', [AuthController::class, 'logout']);
});

Route::group(['middleware' => 'auth:admin', 'prefix' => 'admin'], function () {
    // users
    Route::post('/create/{tipe}', [AdminController::class, 'createUser']);
    Route::get('/users/{tipe}', [AdminController::class, 'getUsers']);
    Route::get('/user/{tipe}/{id}', [AdminController::class, 'getUser']);
    Route::put('/user/{tipe}/{id}', [AdminController::class, 'updateUser']);
    Route::delete('/user/{tipe}/{id}', [AdminController::class, 'deleteUser']);

    Route::post('/profile', [AdminController::class, 'updateProfile']);
    Route::get('/logout', [AuthController::class, 'logout']);
});

Route::get('access_token', [AccessTokenController::class, 'generate_token']);

Route::prefix('download')->group(function() {
    Route::get('/kuis/{id}', function($id) {
        $data = Kuis::find($id);
        $file = public_path('f/kuis/'.$data->file);
        return response()->download($file);
    });
    Route::get('/materi/{id}', function($id) {
        $data = Materi::find($id);
        $file = public_path('f/materi/'.$data->file);
        return response()->download($file);
    });
    Route::get('/tugas-masuk/{id}', function($id) {
        $data = TugasMasuk::find($id);
        $file = public_path('f/tugas/'.$data->id_tugas.'/'.$data->file);
        return response()->download($file);
    });
    Route::get('/kuis-masuk/{id}', function($id) {
        $data = KuisTerkumpul::find($id);
        $file = public_path('f/kuis/'.$data->id_kuis.'/'.$data->file);
        return response()->download($file);
    });
});


// Auth
Route::post('/login', [AuthController::class, 'loginUser']);
Route::post('/dosen/login', [AuthController::class, 'loginDosen']);
Route::post('/admin/login', [AuthController::class, 'loginAdmin']);
