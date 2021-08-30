<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EmailVerificationController;


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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });



Route::post('register', 'API\AuthController@register');
Route::post('login', 'API\AuthController@login');

Route::get('/getRegion', 'API\LocationController@locations')->name('api-locations');

Route::post('forgot-password', 'API\NewPasswordController@forgotPassword');
Route::post('reset-password', 'API\NewPasswordController@reset');

Route::post('email/verification-notification', [EmailVerificationController::class, 'sendVerificationEmail'])->middleware('auth:sanctum');
Route::get('verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify')->middleware('auth:sanctum');



Route::prefix('v1')->middleware(['auth:api'])->group(function () {
    Route::post('ubah-password', 'API\NewPasswordController@ubah');
    Route::get('logout', 'API\AuthController@logout');
    Route::get('get-absensi/masuk', 'API\AbsensiController@getAbsenMasuk');
    Route::post('absensi/masuk', 'API\AbsensiController@absenMasuk');
    Route::post('absensi/pulang', 'API\AbsensiController@absenPulang');
    Route::post('report/pekerjaan-sebelum', 'API\PekerjaanController@reportSebelum');
    Route::post('report/pekerjaan-sesudah/{id}', 'API\PekerjaanController@reportSesudah');
    Route::get('pekerjaan', 'API\PekerjaanController@index');
    Route::get('pekerjaan/{id}', 'API\PekerjaanController@show');
    Route::post('pekerjaan', 'API\PekerjaanController@store');
    Route::put('pekerjaan/{id}', 'API\PekerjaanController@update'); //BISA UNTUK APPROVAL JUGA
    Route::delete('pekerjaan/{id}', 'API\PekerjaanController@delete');
    Route::get('sow', 'API\MasterDataController@sow');
    Route::get('kategori-sow/{id}', 'API\MasterDataController@kategoriSow');
    Route::get('detail-sow/{id}', 'API\MasterDataController@detailSow');
    Route::get('absen', 'API\MasterDataController@absen');
    Route::get('status-laporan', 'API\MasterDataController@statusLaporan');
    Route::get('report/on-progress', 'API\MasterDataController@pekerjaanOnProgress');
});
Route::get('pekerjaan/{filename}', 'API\MasterDataController@fotoPekerjaan');
Route::get('sow/{filename}', 'API\MasterDataController@fotoSow');
Route::get('foto_absensi/{filename}', 'API\MasterDataController@fotoAbsensi');
