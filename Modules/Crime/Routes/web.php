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

Route::prefix('crime')->group(function () {
    Route::get('/tester', 'CrimeController@tester');


    Route::get('/dashboard', 'CrimeController@index_v2');
    Route::get('/dashboard_v2', 'CrimeController@index_v2');

    Route::post('/graphicJakartaSetahun', 'CrimeController@graphicJakartaSetahun');
    Route::post('/graphicKarawangSetahun', 'CrimeController@graphicKarawangSetahun');
    Route::post('/graphicKecJakartaSetahun', 'CrimeController@graphicKecamatanJakutSetahun');
    Route::post('/graphicKecKarawangSetahun', 'CrimeController@graphicKecamatanKarawangSetahun');

    Route::post('/mapingKategoriJakut', 'CrimeController@mapingKategoriJakut');
    Route::post('/mapingKategoriKarawang', 'CrimeController@mapingKategoriKarawang');
    Route::post('/mapJakut', 'CrimeController@mapJakut');
    Route::post('/mapKarawang', 'CrimeController@mapKarawang');



    Route::get('/upload', 'UploadController@index');
    Route::post('/upload_data', 'UploadController@upload_data');
    Route::get('/getList_crime', 'UploadController@getList_crime');
});
