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

use Modules\GuardTour\Http\Controllers\CompanyController;
use Modules\GuardTour\Http\Controllers\PlantsController;
use Modules\GuardTour\Http\Controllers\SiteController;

Route::prefix('guardtour')->group(function () {

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
    Route::get('/plant/master', [PlantsController::class, "index"])->name('plant.master');
});
