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

// Shipper routes
//Route::resource('shipper', 'Api\ShipperController');
Route::get('/shipper', 'Api\ShipperController@index')->name('api.shipper.index');
Route::get('/shipper/{id}', 'Api\ShipperController@show')->name('api.shipper.show');
Route::post('/shipper', 'Api\ShipperController@store')->name('api.shipper.store');
Route::put('/shipper/{id}', 'Api\ShipperController@update')->name('api.shipper.update');
Route::delete('/shipper/{id}', 'Api\ShipperController@destroy')->name('api.shipper.destroy');
Route::get("/shippers/distinct-name", 'Api\ShipperController@distinctNames')->name('api.shipper.distinct-name');
Route::get("/shippers/distinct-company", 'Api\ShipperController@distinctCompanies')->name('api.shipper.distinct-company');
