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

// Driver
Route::resource('driver', 'DriverController');
Route::get('/driver/getDrivers', 'DriverController@getDrivers')->name('driver.drivers');
Route::get('/driver/driver-table', 'DriverController@driverTable')->name('driver.table');

// Item
Route::get('/item', 'ItemController@index')->name('item');
Route::get('/item/getItemList', 'Api\ItemController@getItemList')->name('item.list');
Route::get('/item/create', 'ItemController@create')->name('item.create');
Route::get('/item/getVehicleNumbers', 'Api\ItemController@getVehicleNumbers')->name('vehicle.vehicleNumbers');

// Invoice
Route::get('/invoice', 'InvoiceController@index')->name('invoice.index');

// Unit price
Route::get('/unit-price', 'UnitPriceController@index')->name('unit-price.index');

// Deposit list
Route::get('/deposit', 'DepositController@index')->name('deposit.index');