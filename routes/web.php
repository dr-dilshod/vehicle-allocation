<?php

use Illuminate\Support\Facades\Auth;
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



Route::get('/', 'TopController@index')->name('home');

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
]);

Route::get('/top', 'TopController@index')->name('top');
Route::get('/setting', 'SettingController@index')->middleware('admin')->name('setting');

// Vehicle
Route::get('/vehicle', 'VehicleController@index')->name('vehicle');
Route::get('/vehicle/vehicle-table', 'VehicleController@vehicleTable')->name('vehicle.table');
Route::get('/vehicle/companies', 'VehicleController@companies')->name('vehicle.companies');


// Shipper
Route::get('/shipper', 'ShipperController@index')->name('shipper.index');

// Driver
Route::resource('driver', 'DriverController');
Route::get('/driver/driver-table', 'DriverController@driverTable')->name('driver.table');

// Item
Route::get('/item', 'ItemController@index')->name('item.index');
Route::get('/item/getItemList', 'Api\ItemController@getItemList')->name('item.list');
Route::get('/item/getInitializerList', 'Api\ItemController@getInitializerList')->name('item.list.initialize');
Route::get('/item/create', 'ItemController@create')->name('item.create');
Route::get('/item/register', 'ItemController@register')->name('item.register');
Route::get('/item/edit', 'ItemController@edit')->name('item.edit');
Route::get('/item/getItemList', 'Api\ItemController@getItemList')->name('item.list');
Route::get('/item/getVehicleNumbers', 'Api\ItemController@getVehicleNumbers')->name('item.vehicleNumbers');
Route::get('/item/getVehicles', 'Api\ItemController@getVehicles')->name('item.vehicles');
Route::get('/item/getItemShippers', 'Api\ItemController@getItemShippers')->name('item.shippers.dropdown');
Route::get('/item/getDrivers', 'Api\ItemController@getDrivers')->name('item.drivers');
Route::get('/item/getShippers', 'Api\ItemController@getShippers')->name('item.shippers');
Route::get('/item/getUnitPrice', 'Api\ItemController@getUnitPrice')->name('item.unit_price');
Route::get('/item/toIncomplete', 'Api\ItemController@toIncomplete');
Route::get('/item/setTodayAsCompletion', 'Api\ItemController@setTodayAsCompletion');
Route::get('/item/setDeptDateAsCompletion', 'Api\ItemController@setDeptDateAsCompletion');


// Invoice
Route::get('/invoice', 'InvoiceController@index')->name('invoice.index')->middleware('admin');
Route::get('/invoice/getInvoiceList', 'Api\InvoiceController@getInvoiceList')->name('invoice.list')->middleware('admin');
Route::get('/invoice/getPaymentList', 'Api\InvoiceController@getPaymentList')->name('payment.list')->middleware('admin');
Route::get('/invoice/getDepositList', 'Api\InvoiceController@getDepositList')->name('deposit.list')->middleware('admin');
Route::get('/invoice/getShipperList', 'Api\InvoiceController@getShipperList')->name('shipper.list')->middleware('admin');
Route::get('/invoice/getVehicleList', 'Api\InvoiceController@getVehicleList')->name('vehicle.list')->middleware('admin');
Route::get('/invoice/billingMonthPDF', 'Api\InvoiceController@billingMonthPDF')->name('billing.month')->middleware('admin');
Route::get('/invoice/billingListPDF', 'Api\InvoiceController@billingListPDF')->name('billing.list')->middleware('admin');
Route::get('/invoice/aggregate', 'Api\InvoiceController@getAggregate')->name('api.invoice.aggregate')->middleware('admin');


// Unit price
Route::get('/unit-price', 'UnitPriceController@index')->name('unit-price.index');

// Deposit
Route::get('/deposit', 'DepositController@index')->name('deposit.index')->middleware('admin');

// Payment
Route::get('/payment', 'PaymentController@registration')->name('payment.registration')->middleware('admin');
Route::get('/payment/search', 'Api\PaymentController@search')->name('payment.search')->middleware('admin');;
Route::get('/payment/getShippers', 'Api\PaymentController@getShippers')->name('payment.shippers')->middleware('admin');

// Dispatch list
Route::get('/dispatch', 'DispatchController@index')->name('dispatch.index')->middleware('admin');
Route::get('/dispatch/print', 'DispatchController@printPdf')->name('dispatch.pdf')->middleware('admin');
