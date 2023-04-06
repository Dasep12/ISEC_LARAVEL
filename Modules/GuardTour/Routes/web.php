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


Route::prefix('guardtour')->group(function () {

    //master company
    Route::get('/company/master', [CompanyController::class, "master"])->name('company.master');
    Route::get('/company/form_add', [CompanyController::class, "form_add"])->name('company.form_add');
    Route::post('/company/insert', [CompanyController::class, "insert"])->name('company.insert');
    Route::get('/company/destroy', [CompanyController::class, "destroy"])->name('company.destroy');
    Route::get('/company/form_edit', [CompanyController::class, "form_edit"])->name('company.form_edit');
});
