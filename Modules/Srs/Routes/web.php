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

Route::prefix('srs')->group(function() {
<<<<<<< HEAD
    Route::get('/', 'SrsController@index');
=======
    // Route::get('/', 'SrsController@index');
    Route::get('/dashboard', 'DashboardController@index');
>>>>>>> ad9ebfa0f56bc63ce53fb64d4baf6e89c240a5ff
});
