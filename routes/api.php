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
Route::get('/shippers', 'Api\ShipperController@index')->name('api.shipper.index');
Route::post('/shippers/filter', 'Api\ShipperController@filter')->name('api.shipper.filter');
Route::post('/shippers', 'Api\ShipperController@store')->name('api.shipper.store');
Route::get("/shippers/distinct-name", 'Api\ShipperController@distinctNames')->name('api.shipper.distinct-name');
Route::get("/shippers/fullname", 'Api\ShipperController@getFullnames')->name('api.shipper.fullname');
Route::get("/shippers/distinct-company", 'Api\ShipperController@distinctCompanies')->name('api.shipper.distinct-company');
Route::get('/shippers/all', 'Api\ShipperController@getShippers')->name('api.shipper.all');
Route::get('/shippers/{id}', 'Api\ShipperController@show')->name('api.shipper.show');
Route::put('/shippers/{id}', 'Api\ShipperController@update')->name('api.shipper.update');
Route::delete('/shippers/{id}', 'Api\ShipperController@destroy')->name('api.shipper.destroy');
/*
 * Item CRUD
 */
Route::get('/item', 'Api\ItemController@index')->name('api.item.index');
Route::get('/item/toIncomplete', 'Api\ItemController@toIncomplete');
Route::get('/item/setTodayAsCompletion', 'Api\ItemController@setTodayAsCompletion');
Route::get('/item/setDeptDateAsCompletion', 'Api\ItemController@setDeptDateAsCompletion');
Route::get('/item/{id}', 'Api\ItemController@show')->name('api.item.show');
Route::post('/item', 'Api\ItemController@store')->name('api.item.store');
Route::put('/item/{id}', 'Api\ItemController@update')->name('api.item.update');
Route::delete('/item/{id}', 'Api\ItemController@destroy')->name('api.item.destroy');


/**
 * Unit prices CrUD
 */
Route::get('/unit-prices/shipper-names', 'Api\UnitPriceController@getDistrictShipperNames')->name('api.unit-prices.shipper-names');
Route::get('/unit-prices/vehicle-types', 'Api\UnitPriceController@getVehicleTypes')->name('api.unit-prices.vehicle-types');
Route::get('/unit-prices', 'Api\UnitPriceController@index')->name('api.unit-prices.index');
Route::get('/unit-prices/show/{id}', 'Api\UnitPriceController@show')->name('api.unit-prices.show');
Route::post('/unit-prices', 'Api\UnitPriceController@store')->name('api.unit-prices.store');
Route::post('/unit-prices/{id}', 'Api\UnitPriceController@update')->name('api.unit-prices.update');
Route::delete('/unit-prices/{id}', 'Api\UnitPriceController@destroy')->name('api.unit-prices.destroy');

/**
 * Deposit APIs
 */
Route::post('/deposits/filter', 'Api\DepositController@filter')->name('api.deposit.filter')->middleware('admin');
Route::post('/deposits', 'Api\DepositController@store')->name('api.deposit.store')->middleware('admin');
Route::get('/deposits', 'Api\DepositController@index')->name('api.deposit.index')->middleware('admin');
Route::put('/deposits/{id}', 'Api\DepositController@update')->name('api.deposit.update')->middleware('admin');
Route::get('/deposits/{id}', 'Api\DepositController@show')->name('api.deposit.show')->middleware('admin');
Route::delete('/deposits/{id}', 'Api\DepositController@destroy')->name('api.deposit.destroy')->middleware('admin');

/**
 * Payment APIs
 */
Route::get('payment/registration', 'Api\PaymentController@index')->name('api.payment.registration')->middleware('admin');
Route::get('payment/bk-report', 'Api\PaymentController@index')->name('api.payment.bk-report')->middleware('admin');
Route::post('/payments/filter', 'Api\PaymentController@filter')->name('api.payment.filter')->middleware('admin');
Route::get('/payments', 'Api\PaymentController@index')->name('api.payment.index')->middleware('admin');
Route::post('/payments', 'Api\PaymentController@store')->name('api.payment.store')->middleware('admin');
Route::put('/payments/{id}', 'Api\PaymentController@update')->name('api.payment.update')->middleware('admin');
Route::get('/payments/{id}', 'Api\PaymentController@show')->name('api.payment.show')->middleware('admin');
Route::delete('/payments/{id}', 'Api\PaymentController@destroy')->name('api.payment.destroy')->middleware('admin');

/**
 * Invoice APIs
 */
Route::get('/invoice', 'Api\InvoiceController@index')->name('api.invoice.index')->middleware('admin');
Route::delete('/invoice/{id}', 'Api\InvoiceController@destroy')->name('api.invoice.destroy')->middleware('admin');
Route::post('/invoice', 'Api\InvoiceController@store')->name('api.invoice.store')->middleware('admin');


// Dispatch
Route::get('/dispatch', 'Api\DispatchController@index')->name('api.dispatch.index');
Route::post('/dispatch', 'Api\DispatchController@store')->name('api.dispatch.store');
Route::delete('/dispatch/{id}', 'Api\DispatchController@destroy')->name('api.dispatch.destroy');
Route::post('/dispatch/third-list', 'Api\DispatchController@thirdList')->name('api.dispatch.third');

// Top
Route::get('/top', 'Api\TopController@index')->name('api.top.index');
Route::get('/top/month', 'Api\TopController@getByMonth')->name('api.top.month');
