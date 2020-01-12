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

// Vehicle
Route::get('/vehicle', 'VehicleController@index')->name('vehicle');
Route::get('/vehicle/vehicle-table', 'VehicleController@vehicleTable')->name('vehicle.table');
Route::get('/vehicle/companies', 'VehicleController@companies')->name('vehicle.companies');
//Route::post('/vehicle/store', 'VehicleController@store')->name('vehicle.store');
//Route::get('/vehicle/show', 'VehicleController@show')->name('vehicle.show');
//Route::put('/vehicle/update', 'VehicleController@update')->name('vehicle.update');
//Route::delete('/vehicle/delete', 'VehicleController@destroy')->name('vehicle.destroy');

// Shipper
Route::resource('shipper', 'ShipperController');
Route::resource('api/shipper', 'Api\ShipperController');
Route::get('/shipper/getShippers', 'Api\ShipperController@getShippers')->name('shipper.shippers');

// Driver
Route::resource('driver', 'DriverController');

// Item
Route::get('/item', 'ItemController@index')->name('item');
Route::get('/item/create', 'ItemController@create')->name('item.create');
Route::resource('api/item', 'Api\ItemController');

