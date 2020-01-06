<?php

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

Route::get('/', 'TopController@index')->name('home');

Auth::routes();

Route::get('/top', 'TopController@index')->name('top');
Route::get('/setting', 'SettingController@index')->name('setting');
Route::get('/vehicles/data-table', 'VehicleController@getVehicleTableData')->name('vehicle.table');

Route::resource('shipper', 'ShipperController');

Route::resource('vehicle','VehicleController')->names([
    'create' => 'vehicle.create',
    'store' => 'vehicle.store'
]);;


Route::resource('driver', 'DriverController');
