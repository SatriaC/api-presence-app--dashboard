<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Route::get('/','DashboardController@index')->name('dashboard');
Route::prefix('monitor')
    // ->namespace('Admin')
    // ->middleware(['auth','admin'])
    ->group(function(){
        Route::resource('bagian', 'DivisionController');
        Route::resource('karyawan', 'KaryawanController');
        Route::resource('detail-sow', 'DetailSowController');
        Route::resource('sow', 'SowController');
        Route::resource('kehadiran', 'KehadiranController');
        Route::resource('pekerjaan', 'PekerjaanController');
    });
