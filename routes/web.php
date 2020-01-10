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
Route::get('/vehicle/data-table', 'VehicleController@getVehicleTableData')->name('vehicle.table');
Route::get('/vehicle/companies', 'VehicleController@getCompanies')->name('vehicle.companies');

Route::resource('shipper', 'ShipperController');
Route::resource('api/shipper', 'Api\ShipperController');

Route::resource('vehicle','VehicleController')->names([
    'create' => 'vehicle.create',
    'store' => 'vehicle.store'
]);;


Route::resource('driver', 'DriverController');
Route::get('/item', 'ItemController@index')->name('item');
Route::get('/item/create', 'ItemController@create')->name('item.create');
Route::resource('api/item', 'Api\ItemController');

