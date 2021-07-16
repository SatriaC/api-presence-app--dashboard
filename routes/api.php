<?php

use Illuminate\Http\Request;
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

Route::get('/getRegion', 'API\LocationController@locations')->name('api-locations');

Route::get('users', 'API\UserController@index');
Route::get('users/{id}', 'API\UserController@show');
Route::post('users', 'API\UserController@store');
Route::put('users/{id}', 'API\UserController@update');
Route::delete('users/{id}', 'API\UserController@delete');

Route::get('pekerjaan', 'API\PekerjaanController@index');
Route::get('pekerjaan/{id}', 'API\PekerjaanController@show');
Route::post('pekerjaan', 'API\PekerjaanController@store');
Route::put('pekerjaan/{id}', 'API\PekerjaanController@update'); //BISA UNTUK APPROVAL JUGA
Route::delete('pekerjaan/{id}', 'API\PekerjaanController@delete');
