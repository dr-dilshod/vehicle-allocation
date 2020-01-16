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

// Shipper
Route::resource('shipper', 'ShipperController');
Route::get('/shipper/getShippers', 'Api\ShipperController@getShippers')->name('shipper.shippers');

// Driver
Route::resource('driver', 'DriverController');
Route::get('/driver/getDrivers', 'DriverController@getDrivers')->name('driver.drivers');
Route::get('/driver/driver-table', 'DriverController@driverTable')->name('driver.table');

// Item
Route::get('/item/index', 'ItemController@index')->name('item.index');
Route::get('/item/create', 'ItemController@create')->name('item.create');

// Invoice
Route::get('/invoice', 'InvoiceController@index')->name('invoice.index');

// Unit price
Route::get('/unit-price', 'UnitPriceController@index')->name('unit-price.index');
