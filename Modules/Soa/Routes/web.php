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

    Route::get('/tester', 'DashboardController@tester');

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

    Route::post('/scaterBarang', 'DashboardController@scaterBarang');
    Route::get('/scaterBarang', 'DashboardController@scaterBarang');

    Route::post('/pkbAllPlants', 'DashboardController@pkbAllPlants');
    Route::post('/pkbPlantSetahun', 'DashboardController@pkbPlantSetahun');
    Route::post('/pkbByDepartement', 'DashboardController@pkbByDepartement');
    Route::post('/pkbByDepartementAll', 'DashboardController@pkbByDepartementAll');
    Route::post('/pkbByUser', 'DashboardController@pkbByUser');
    Route::post('/pkbByUserAll', 'DashboardController@pkbByUserAll');
    Route::post('/pkbByKategoriBarang', 'DashboardController@pkbKategoriBarang');
    Route::post('/pkbStatus', 'DashboardController@pkbStatus');



    // uploads
    Route::get('/upload', 'UploadController@index');
    Route::post('/uploadFile', 'UploadController@uploads');


    // upload egate 
    Route::get('/uploadEgate', 'UploadEgateController@index');
    Route::post('/uploadEgate/uploadFile', 'UploadEgateController@uploads')->name('egate.uploaded');



    // view & from
    Route::get('/forms', 'SoaController@index');
    Route::post('/saveSoa', 'SoaController@saveSoa');
    Route::get('/formEditSoa', 'SoaController@formEdit');
    Route::post('/updateSoa', 'SoaController@updateSoa');
    Route::post('/dataTables', 'SoaController@dataTables');
    Route::post('/detailSoa', 'SoaController@detailSoa');
    Route::post('/deleteData', 'SoaController@deleteData');
    Route::get('/form_upload_visitor', 'SoaController@form_upload_visitor');
    Route::post('/uploads_visitor', 'SoaController@uploads_visitor')->name('egate.uploadedVisitor');
});
