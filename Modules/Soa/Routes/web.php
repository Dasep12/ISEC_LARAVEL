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

    Route::post('/pkbAllPlants', 'DashboardController@pkbAllPlants');
    Route::post('/pkbPlantSetahun', 'DashboardController@pkbPlantSetahun');
    Route::post('/pkbByDepartement', 'DashboardController@pkbByDepartement');
    Route::post('/pkbByDepartementAll', 'DashboardController@pkbByDepartementAll');
    Route::post('/pkbByUser', 'DashboardController@pkbByUser');
    Route::post('/pkbByUserAll', 'DashboardController@pkbByUserAll');



    // uploads
    Route::get('/upload', 'UploadController@index');
    Route::post('/uploadFile', 'UploadController@uploads');


    // view & from
    Route::get('/forms', 'SoaController@index');
    Route::post('/saveSoa', 'SoaController@saveSoa');
    Route::get('/formEditSoa', 'SoaController@formEdit');
    Route::post('/updateSoa', 'SoaController@updateSoa');
    Route::post('/dataTables', 'SoaController@dataTables');
    Route::post('/detailSoa', 'SoaController@detailSoa');
    Route::post('/deleteData', 'SoaController@deleteData');
});
