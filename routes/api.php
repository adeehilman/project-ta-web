<?php

use App\Http\Controllers\LokerController;
use App\Http\Controllers\PemberitahuanController;
use App\Http\Controllers\KritikController;
use App\Http\Controllers\JWTAuthController;
use App\Http\Controllers\TaskScheduleController;
use App\Http\Controllers\Api\UploadFileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotifikasiController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//   return $request->user();
// });

Route::get('list-question', [JWTAuthController::class, 'listQuestion']);
Route::post('login', [JWTAuthController::class, 'login']);
Route::post('register', [JWTAuthController::class, 'register']);
Route::post('forget-password', [JWTAuthController::class, 'forgetPassword']);



Route::group(['middleware' => ['api', 'auth:api']], function () {
  Route::get('/pemberitahuan', [PemberitahuanController::class, 'list']);
  Route::get('/pemberitahuan/penerima/{pemberitahuanId}', [PemberitahuanController::class, 'getReceiver']);
  Route::get('/pemberitahuan/{id}', [PemberitahuanController::class, 'show']);
  Route::post('/pemberitahuan', [PemberitahuanController::class, 'store']);
  Route::put('/pemberitahuan/{id}', [PemberitahuanController::class, 'update']);
  Route::delete('/pemberitahuan/{id}', [PemberitahuanController::class, 'destroy']);

  Route::get('/loker', [LokerController::class, 'list']);
  Route::get('/loker/{id}', [LokerController::class, 'show']);
  Route::post('/loker', [LokerController::class, 'store']);
  Route::put('/loker/{id}', [LokerController::class, 'update']);
  Route::delete('/loker/{id}', [LokerController::class, 'destroy']);

  Route::get('/kritik', [KritikController::class, 'list']);
  Route::get('/kritik/{id}', [KritikController::class, 'show']);
  Route::post('/kritik', [KritikController::class, 'store']);
  Route::put('/kritik/{id}', [KritikController::class, 'update']);
  Route::delete('/kritik/{id}', [KritikController::class, 'destroy']);
});

Route::post('upload-file', [UploadFileController::class, 'uploadFile']);

Route::get('/get_data_karyawan', [TaskScheduleController::class, 'getDataKaryawan']);
Route::get('/check_data_karyawan', [TaskScheduleController::class, 'checkDataKaryawan']);
Route::get('/get_img_blob_to_base64', [TaskScheduleController::class, 'getBlobtoBase64']);
Route::get('/local_blob_to_base64', [TaskScheduleController::class, 'localBlobtoBase64']);
Route::get('/check_imei', [TaskScheduleController::class, 'checkImei']);
Route::get('/delete_already_get', [TaskScheduleController::class, 'deleteAlreadyGet']);
Route::get('/check_count_table_dump', [TaskScheduleController::class, 'checkCountTableDump']);
Route::get('/convert_blob_jpg', [TaskScheduleController::class, 'convertBlobKeJpg']);
Route::get('/karyawan_image_to_base64', [TaskScheduleController::class, 'karyawanImagetoBase64']);
Route::get('/data_local_to_server', [TaskScheduleController::class, 'dataLocaltoServer']);

// update gambar karyawan jika null
Route::get('/fetch_gambar_karyawan', [TaskScheduleController::class, 'fetchGambarKaryawan']);

// Route::post('/loker', [LokerController::class, 'store']);checkCountTableDump
// Route::put('/loker/{id}', [LokerController::class, 'update']);
// Route::delete('/loker/{id}', [LokerController::class, 'destroy']);

/**
 * handle navbar api response
 */
Route::get('/notifikasi', [NotifikasiController::class, 'getCountNotif'])->name('api.notifikasi');
