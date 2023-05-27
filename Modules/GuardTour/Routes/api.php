<?php


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

use Modules\GuardTour\Http\Controllers\api\AuthController;
use Modules\GuardTour\Http\Controllers\api\JadwalController;
use Modules\GuardTour\Http\Controllers\api\PatroliController;

Route::post('/auth/login', [AuthController::class, 'login']);

Route::controller(JadwalController::class)->group(function () {
    Route::get('/patroli/jadwalPatroli', 'jadwalUser')->middleware('api_token');
    Route::get('/patroli/shift', 'shift')->middleware('api_token');
});

Route::controller(PatroliController::class)->group(function () {
    Route::get('/patroli/dataPatroli', 'dataPatroli')->middleware('api_token');
    Route::post('/patroli/dataTemuan', 'dataTemuan')->middleware('api_token');
    Route::get('/patroli/getPatrolActivity', 'getPatrolActivity')->middleware('api_token');
    Route::get('/patroli/getDataTemuan', 'getdataTemuan')->middleware('api_token');
    Route::post('/patroli/setPatrolActivity', 'setPatrolActivity')->middleware('api_token');
});



// API VERSION 