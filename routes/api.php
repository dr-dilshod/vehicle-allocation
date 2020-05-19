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

/*
 * Vehicle CRUD
 */
Route::get('/vehicle', 'Api\VehicleController@index')->name('api.vehicle.index')->middleware('admin');
Route::get('/vehicle/companies', 'Api\VehicleController@getCompanies')->name('api.vehicle.companies')->middleware('admin');
Route::get('/vehicle/{id}', 'Api\VehicleController@show')->name('api.vehicle.show')->middleware('admin');
Route::post('/vehicle', 'Api\VehicleController@store')->name('api.vehicle.store')->middleware('admin');
Route::post('/vehicle/update', 'Api\VehicleController@update')->name('api.vehicle.update')->middleware('admin');
Route::post('/vehicle/destroy', 'Api\VehicleController@destroy')->name('api.vehicle.destroy')->middleware('admin');

/*
 * Driver CRUD
 */
Route::get('/driver', 'Api\DriverController@index')->name('api.driver.index')->middleware('admin');
Route::get('/driver/{id}', 'Api\DriverController@show')->name('api.driver.show')->middleware('admin');
Route::post('/driver/store', 'Api\DriverController@store')->name('api.driver.store')->middleware('admin');
Route::post('/driver/update', 'Api\DriverController@update')->name('api.driver.update')->middleware('admin');
Route::post('/driver/destroy', 'Api\DriverController@destroy')->name('api.driver.destroy')->middleware('admin');
Route::get('/drivers/vehicle-numbers', 'Api\DriverController@getVehicleNumbers')->name('api.driver.vehicle-numbers')->middleware('admin');

// Shipper routes
Route::get('/shippers', 'Api\ShipperController@index')->name('api.shipper.index')->middleware('admin');
Route::post('/shippers/filter', 'Api\ShipperController@filter')->name('api.shipper.filter')->middleware('admin');
Route::post('/shippers', 'Api\ShipperController@store')->name('api.shipper.store')->middleware('admin');
Route::get("/shippers/distinct-name", 'Api\ShipperController@distinctNames')->name('api.shipper.distinct-name')->middleware('admin');
Route::get("/shippers/fullname", 'Api\ShipperController@getFullnames')->name('api.shipper.fullname')->middleware('admin');
Route::get("/shippers/distinct-company", 'Api\ShipperController@distinctCompanies')->name('api.shipper.distinct-company')->middleware('admin');
Route::get('/shippers/all', 'Api\ShipperController@getShippers')->name('api.shipper.all')->middleware('admin');
Route::get('/shippers/{id}', 'Api\ShipperController@show')->name('api.shipper.show')->middleware('admin');
Route::post('/shippers/delete', 'Api\ShipperController@destroy')->name('api.shipper.destroy')->middleware('admin');
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
Route::get('/unit-prices/shipper-names', 'Api\UnitPriceController@getDistrictShipperNames')->name('api.unit-prices.shipper-names')->middleware('admin');
Route::get('/unit-prices/all-shippers', 'Api\UnitPriceController@getAllShipperNames')->name('api.unit-prices.all-shippers')->middleware('admin');
Route::get('/unit-prices/vehicle-types', 'Api\UnitPriceController@getVehicleTypes')->name('api.unit-prices.vehicle-types')->middleware('admin');
Route::get('/unit-prices', 'Api\UnitPriceController@index')->name('api.unit-prices.index')->middleware('admin');
Route::get('/unit-prices/show/{id}', 'Api\UnitPriceController@show')->name('api.unit-prices.show')->middleware('admin');
Route::post('/unit-prices', 'Api\UnitPriceController@store')->name('api.unit-prices.store')->middleware('admin');
Route::put('/unit-prices/{id}', 'Api\UnitPriceController@update')->name('api.unit-prices.update')->middleware('admin');
Route::delete('/unit-prices/{id}', 'Api\UnitPriceController@destroy')->name('api.unit-prices.destroy')->middleware('admin');
Route::post('/unit-prices/register', 'Api\UnitPriceController@register')->name('api.unit-prices.register')->middleware('admin');


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
Route::get('/invoice/stack-points', 'Api\InvoiceController@stackPoints')->name('api.invoice.stackpoints')->middleware('admin');
Route::get('/invoice/down-points', 'Api\InvoiceController@downPoints')->name('api.invoice.downpoints')->middleware('admin');
Route::get('/invoice', 'Api\InvoiceController@index')->name('api.invoice.index')->middleware('admin');
Route::get('/invoice/filter', 'Api\InvoiceController@getInvoiceList')->name('api.invoice.filter')->middleware('admin');
Route::delete('/invoice/{id}', 'Api\InvoiceController@destroy')->name('api.invoice.destroy')->middleware('admin');
Route::post('/invoice', 'Api\InvoiceController@store')->name('api.invoice.store')->middleware('admin');


// Dispatch
Route::get('/dispatch/first-list', 'Api\DispatchController@firstList')->name('api.dispatch.first')->middleware('admin');
Route::get('/dispatch/second-list', 'Api\DispatchController@secondList')->name('api.dispatch.second')->middleware('admin');
Route::post('/dispatch/third-list', 'Api\DispatchController@thirdList')->name('api.dispatch.third')->middleware('admin');
Route::get('/dispatch/driver-list', 'Api\DispatchController@driverList')->name('api.dispatch.drivers')->middleware('admin');
Route::post('/dispatch', 'Api\DispatchController@store')->name('api.dispatch.store')->middleware('admin');
Route::delete('/dispatch/{id}', 'Api\DispatchController@destroy')->name('api.dispatch.destroy')->middleware('admin');

// Top
Route::get('/top', 'Api\TopController@index')->name('api.top.index');
Route::get('/top/all', 'Api\TopController@getAll')->name('api.top.all')->middleware('admin');
Route::get('/top/month', 'Api\TopController@getByMonth')->name('api.top.month')->middleware('admin');
