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
