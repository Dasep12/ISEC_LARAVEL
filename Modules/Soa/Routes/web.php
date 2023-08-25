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



Route::prefix('soa')->group(function () {
    Route::get('/dashboard', 'DashboardController@index');
    Route::post('/peopleAll', 'DashboardController@peopleAll');
    Route::post('/vehicleAll', 'DashboardController@vehicleAll');
    Route::post('/documentAll', 'DashboardController@documentAll');
    Route::post('/peopleDays', 'DashboardController@peopleDays');
    Route::post('/vehicleDays', 'DashboardController@vehicleDays');
    Route::post('/documentDays', 'DashboardController@documentDays');
    Route::post('/vehicleCategory', 'DashboardController@vehicleCategory');
    Route::post('/peopleCategory', 'DashboardController@peopleCategory');
    Route::post('/documentCategory', 'DashboardController@documentCategory');
    Route::post('/grapichSetahun', 'DashboardController@grapichSetahun');
});
