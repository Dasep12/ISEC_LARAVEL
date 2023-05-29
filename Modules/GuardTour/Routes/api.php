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

//  API A
use Modules\GuardTour\Http\Controllers\api\AuthController;
use Modules\GuardTour\Http\Controllers\api\JadwalController;
use Modules\GuardTour\Http\Controllers\api\PatroliController;

// END

// API B
use Modules\GuardTour\Http\Controllers\api_b\PatroliController_B;
use Modules\GuardTour\Http\Controllers\api_b\AuthController_B;
// END

// API VERSION A
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
// END



// API VERSION B
Route::post('/patroli/login', [AuthController_B::class, 'login']);
Route::post('/patroli/zonaPatroli', [PatroliController_B::class, 'getZonaPatroli']);
Route::get('/patroli/checkpoint_', [PatroliController_B::class, 'getCheckpointPatroli']);
Route::get('/patroli/objek_', [PatroliController_B::class, 'getObjekPatroli']);
Route::get('/patroli/event_', [PatroliController_B::class, 'getEventPatroli']);
Route::post('/patroli/timeout', [PatroliController_B::class, 'HitungWaktuPatroli']);
Route::post('/patroli/temuan', [PatroliController_B::class, 'ShowCheck']);
Route::post('/patroli/persentasepatroli', [PatroliController_B::class, 'persentasePatroli']);
// END