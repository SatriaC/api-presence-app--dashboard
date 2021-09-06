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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/manual-book', 'DashboardController@manualbook')->name('manual-book');
Route::get('/home', 'HomeController@index')->name('home');
Route::middleware(['auth'])
    ->group(function () {
        Route::get('/', 'DashboardController@index')->name('dashboard');
        Route::get('ubah-password', 'UbahPasswordController@index')->name('ubah-password');
        Route::post('/change-passwords', 'UbahPasswordController@changePassword')->name('password.change');
    });

Route::prefix('master-data')
    ->middleware(['auth', 'checkRole:1'])
    ->group(function () {
        Route::post('detail-sow', 'DetailSowController@store')->name('detail-sow.store');
        Route::get('/detail-sow/{id}/edit', 'DetailSowController@edit')->name('detail-sow.edit');
        Route::put('/detail-sow/{id}', 'DetailSowController@update')->name('detail-sow.update');
        Route::delete('/detail-sow/{id}', 'DetailSowController@destroy')->name('detail-sow.destroy');
        Route::post('kategori-sow', 'KategoriSowController@store')->name('kategori-sow.store');
        Route::get('/kategori-sow/{id}/edit', 'KategoriSowController@edit')->name('kategori-sow.edit');
        Route::put('/kategori-sow/{id}', 'KategoriSowController@update')->name('kategori-sow.update');
        Route::delete('/kategori-sow/{id}', 'KategoriSowController@destroy')->name('kategori-sow.destroy');
        Route::post('sow', 'SowController@store')->name('sow.store');
        Route::get('/sow/{id}/edit', 'SowController@edit')->name('sow.edit');
        Route::put('/sow/{id}', 'SowController@update')->name('sow.update');
        Route::delete('/sow/{id}', 'SowController@destroy')->name('sow.destroy');
        Route::resource('bagian', 'DivisionController');
        Route::resource('karyawan', 'KaryawanController');
    });
Route::prefix('master-data')
    ->middleware(['auth', 'checkRole:1,2,3'])
    ->group(function () {
        Route::get('sow', 'SowController@index')->name('sow.index');
        Route::get('kategori-sow', 'KategoriSowController@index')->name('kategori-sow.index');
        Route::get('detail-sow', 'DetailSowController@index')->name('detail-sow.index');
        Route::resource('detail-sow', 'DetailSowController')->except(['create','update','edit','destroy', 'show']);
        Route::resource('kategori-sow', 'KategoriSowController')->except(['create','update','edit','destroy', 'show']);
        Route::resource('sow', 'SowController')->except(['create','update','edit','destroy', 'show']);
    });
Route::prefix('report')
    // ->namespace('Admin')
    ->middleware(['auth'])
    ->group(function () {
        Route::resource('kehadiran', 'KehadiranController');
        Route::resource('pekerjaan', 'PekerjaanController');
        Route::put('pekerjaan/{id}/approve', 'PekerjaanController@approve')->name('pekerjaan.approve');
        Route::get('pekerjaan/{id}/decline', 'PekerjaanController@decline')->name('pekerjaan.decline');
        Route::put('pekerjaan/{id}/decline', 'PekerjaanController@declinePost')->name('pekerjaan.decline.post');
    });
