<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post('register', 'API\AuthController@register');
Route::post('login', 'API\AuthController@login');

Route::get('/getRegion', 'API\LocationController@locations')->name('api-locations');

// Route::get('users', 'API\UserController@index');
// Route::get('users/{id}', 'API\UserController@show');
// Route::post('users', 'API\UserController@store');
// Route::put('users/{id}', 'API\UserController@update');
// Route::delete('users/{id}', 'API\UserController@delete');


Route::prefix('v1')->middleware(['auth:api'])->group(function () {
    Route::get('logout', 'API\AuthController@logout');
    Route::get('get-absensi/masuk', 'API\AbsensiController@getAbsenMasuk');
    Route::post('absensi/masuk', 'API\AbsensiController@absenMasuk');
    Route::post('absensi/pulang', 'API\AbsensiController@absenPulang');
    Route::post('report/pekerjaan-sebelum', 'API\PekerjaanController@reportSebelum');
    Route::post('report/{id}/pekerjaan-sesudah', 'API\PekerjaanController@reportSesudah');
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
    Route::get('pekerjaan/onProgress', 'API\MasterDataController@pekerjaanOnProgress');
    // Route::get('sow/{filename}', function ($filename) {
    //     $path = storage_path('app/public/assets/ikon-sow/' . $filename);
    //     if (!File::exists($path)) {
    //         return response(['message' => 'File tidak ada'], 404);
    //     }
    //     $file = File::get($path);
    //     $type = File::mimeType($path);
    //     $response = Response::make($file, 200);
    //     $response->header('Content-type', $type);
    //     return $response;
    // });
    Route::get('pekerjaan/{filename}', function ($filename) {
        $path = storage_path('app/public/file/pekerjaan/' . $filename);
        if (!File::exists($path)) {
            return response(['message' => 'File tidak ada'], 404);
        }
        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header('Content-type', $type);
        return $response;
    });
});
Route::get('sow/{filename}', function ($filename) {
    $path = storage_path('app/public/assets/ikon-sow/' . $filename);
    if (!File::exists($path)) {
        return response(['message' => 'File tidak ada'], 404);
    }
    $file = File::get($path);
    $type = File::mimeType($path);
    $response = Response::make($file, 200);
    $response->header('Content-type', $type);
    return $response;
});

Route::get('foto_absensi/{filename}', function ($filename) {
    $path = storage_path('app/public/foto_absensi/' . $filename);
    if (!File::exists($path)) {
        return response(['message' => 'File tidak ada'], 404);
    }
    $file = File::get($path);
    $type = File::mimeType($path);
    $response = Response::make($file, 200);
    $response->header('Content-type', $type);
    return $response;
});
