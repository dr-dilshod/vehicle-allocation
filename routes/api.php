<?php

use Illuminate\Http\Request;

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

/*
 * Vehicle CRUD
 */
Route::get('/vehicle', 'Api\VehicleController@index')->name('api.vehicle.index');
Route::get('/vehicle/{id}', 'Api\VehicleController@show')->name('api.vehicle.show');
Route::post('/vehicle', 'Api\VehicleController@store')->name('api.vehicle.store');
Route::put('/vehicle/{id}', 'Api\VehicleController@update')->name('api.vehicle.update');
Route::delete('/vehicle/{id}', 'Api\VehicleController@destroy')->name('api.vehicle.destroy');

/*
 * Driver CRUD
 */
Route::get('/driver', 'Api\DriverController@index')->name('api.driver.index');
Route::get('/driver/{id}', 'Api\DriverController@show')->name('api.driver.show');
Route::post('/driver', 'Api\DriverController@store')->name('api.driver.store');
Route::put('/driver/{id}', 'Api\DriverController@update')->name('api.driver.update');
Route::delete('/driver/{id}', 'Api\DriverController@destroy')->name('api.driver.destroy');
Route::get('/drivers/vehicle-numbers', 'Api\DriverController@getVehicleNumbers')->name('api.driver.vehicle-numbers');

// Shipper routes
Route::get('/shipper', 'Api\ShipperController@index')->name('api.shipper.index');
Route::get('/shipper/{id}', 'Api\ShipperController@show')->name('api.shipper.show');
Route::post('/shipper', 'Api\ShipperController@store')->name('api.shipper.store');
Route::put('/shipper/{id}', 'Api\ShipperController@update')->name('api.shipper.update');
Route::delete('/shipper/{id}', 'Api\ShipperController@destroy')->name('api.shipper.destroy');
Route::get("/shippers/distinct-name", 'Api\ShipperController@distinctNames')->name('api.shipper.distinct-name');
Route::get("/shippers/distinct-company", 'Api\ShipperController@distinctCompanies')->name('api.shipper.distinct-company');
Route::get('/shippers/all', 'Api\ShipperController@getShippers')->name('api.shipper.all');
/*
 * Item CRUD
 */
Route::get('/item', 'Api\ItemController@index')->name('api.item.index');
Route::get('/item/{id}', 'Api\ItemController@show')->name('api.item.show');
Route::post('/item', 'Api\ItemController@store')->name('api.item.store');
Route::put('/item/{id}', 'Api\ItemController@update')->name('api.item.update');
Route::delete('/item/{id}', 'Api\ItemController@destroy')->name('api.item.destroy');

/**
 * Unit prices CrUD
 */
Route::get('/unit-price', 'Api\UnitPriceController@index')->name('api.unit-price.index');
Route::get('/unit-price/shipper-names', 'Api\UnitPriceController@getDistrictShipperNames')->name('api.unit-price.shipper-names');
Route::get('/unit-price/vehicle-types', 'Api\UnitPriceController@getVehicleTypes');
Route::get('/unit-price/{id}', 'Api\UnitPriceController@show')->name('api.unit-price.show');
Route::post('/unit-price/{id}', 'Api\UnitPriceController@store')->name('api.unit-price.store');
Route::post('/unit-price/{id}', 'Api\UnitPriceController@update')->name('api.unit-price.update');
Route::delete('/unit-price/{id}', 'Api\UnitPriceController@destroy')->name('api.unit-price.destroy');

/**
 * Deposit APIs
 */
Route::get('deposit', 'Api\DepositController@index')->name('api.deposit.index');

// Invoice
Route::get('/invoice', 'Api\InvoiceController@index')->name('api.invoice.index');

// Dispatch
Route::get('/dispatch', 'Api\DispatchController@index')->name('api.dispatch.index');
