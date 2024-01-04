<?php

Route::prefix('srs')->middleware(['is_login_isec','prevent-back-history'])->group(function() {
    Route::get('/dashboard', 'DashboardController@index'); //->middleware('is_login_isec');
    Route::post('/dashboard/grap_srs', 'DashboardController@grap_srs');
    Route::get('/internal_source', 'InternalsourceController@index');
    Route::post('/internal_source/listTable', 'InternalsourceController@listTable');
    Route::get('/internal_source/save', 'InternalsourceController@save');
});
