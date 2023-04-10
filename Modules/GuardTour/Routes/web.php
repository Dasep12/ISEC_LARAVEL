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

use Modules\GuardTour\Http\Controllers\CheckpointController;
use Modules\GuardTour\Http\Controllers\CompanyController;
use Modules\GuardTour\Http\Controllers\PlantsController;
use Modules\GuardTour\Http\Controllers\SiteController;
use Modules\GuardTour\Http\Controllers\ZoneController;
use Modules\GuardTour\Http\Controllers\DashboardController;


Route::prefix('guardtour')->group(function () {


    // dashboard
    Route::get('/dashboard', [DashboardController::class, "index"])->name('dashboard');


    //master company    
    Route::get('/company/master', [CompanyController::class, "master"])->name('company.master');
    Route::get('/company/form_add', [CompanyController::class, "form_add"])->name('company.form_add');
    Route::post('/company/insert', [CompanyController::class, "insert"])->name('company.insert');
    Route::get('/company/destroy', [CompanyController::class, "destroy"])->name('company.destroy');
    Route::get('/company/form_edit', [CompanyController::class, "form_edit"])->name('company.form_edit');
    Route::post('/company/update', [CompanyController::class, "update"])->name('company.update');

    // master wilayah
    Route::get('/site/master', [SiteController::class, "master"])->name('site.master');
    Route::get('/site/form_add', [SiteController::class, "form_add"])->name('site.form_add');
    Route::post('/site/insert', [SiteController::class, "insert"])->name('site.insert');
    Route::get('/site/destroy', [SiteController::class, "destroy"])->name('site.destroy');
    Route::get('/site/form_edit', [SiteController::class, "form_edit"])->name('site.form_edit');
    Route::post('/site/update', [SiteController::class, "update"])->name('site.update');

    // master plant
    Route::get('/plant/master', [PlantsController::class, "master"])->name('plant.master');
    Route::get('/plant/form_add', [PlantsController::class, "form_add"])->name('plant.form_add');
    Route::post('/plant/insert', [PlantsController::class, "insert"])->name('plant.insert');
    Route::get('/plant/destroy', [PlantsController::class, "destroy"])->name('plant.destroy');
    Route::get('/plant/form_edit', [PlantsController::class, "form_edit"])->name('plant.form_edit');
    Route::post('/plant/update', [PlantsController::class, "update"])->name('plant.update');
    Route::post('/plant/getWilayah', [PlantsController::class, "getWilayah"])->name('plant.getWilayah');

    // master zone
    Route::get('/zona/master', [ZoneController::class, "master"])->name('zona.master');
    Route::get('/zona/form_add', [ZoneController::class, "form_add"])->name('zona.form_add');
    Route::post('/zona/insert', [ZoneController::class, "insert"])->name('zona.insert');
    Route::get('/zona/destroy', [ZoneController::class, "destroy"])->name('zona.destroy');
    Route::get('/zona/form_edit', [ZoneController::class, "form_edit"])->name('zona.form_edit');
    Route::post('/zona/update', [ZoneController::class, "update"])->name('zona.update');
    Route::post('/zona/getPlant', [ZoneController::class, "getPlant"])->name('zona.getPlant');

    // master checkpoint
    Route::get('/checkpoint/master', [CheckpointController::class, "master"])->name('checkpoint.master');
    Route::get('/checkpoint/form_add', [CheckpointController::class, "form_add"])->name('checkpoint.form_add');
    Route::post('/checkpoint/insert', [CheckpointController::class, "insert"])->name('checkpoint.insert');
    Route::get('/checkpoint/destroy', [CheckpointController::class, "destroy"])->name('checkpoint.destroy');
    Route::get('/checkpoint/form_edit', [CheckpointController::class, "form_edit"])->name('checkpoint.form_edit');
    Route::post('/checkpoint/update', [CheckpointController::class, "update"])->name('checkpoint.update');
    Route::post('/checkpoint/getZona', [CheckpointController::class, "getZona"])->name('checkpoint.getZona');
});
