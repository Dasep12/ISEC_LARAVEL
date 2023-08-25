<?php

Route::prefix('srs')->middleware(['is_login_isec','prevent-back-history'])->group(function() {
    Route::get('/dashboard', 'DashboardController@index'); //->middleware('is_login_isec');
    Route::post('/dashboard/grap_srs', 'DashboardController@grap_srs');
    Route::post('/dashboard/grap_detail_risk_source', 'DashboardController@grapDetailRiskSource');
    Route::post('/dashboard/grap_detail_assets', 'DashboardController@grapDetailAssets');
    Route::post('/dashboard/grap_detail_risk', 'DashboardController@grapDetailRisk');
    Route::post('/dashboard/grap_trend_soi', 'DashboardController@grapTrendSoi');
    Route::post('/dashboard/grap_risksource_soi', 'DashboardController@grapRiskSourceSoi');
    
    Route::get('/internal_source', 'InternalsourceController@index');
    Route::post('/internal_source/list_table', 'InternalsourceController@listTable');
    Route::get('/internal_source/save', 'InternalsourceController@save');
    Route::get('/internal_source/edit/{id}', 'InternalsourceController@edit');
    Route::post('/internal_source/detail', 'InternalsourceController@detail');

    Route::get('/dashboard_humint', 'DashboardHumintController@index');
    Route::post('/dashboard_humint/grap_srs', 'DashboardHumintController@grapReload');
    Route::post('/dashboard_humint/grap_trend_soi', 'DashboardHumintController@grapTrendSoi');
    Route::post('/dashboard_humint/grap_top_index', 'DashboardHumintController@grapTopIndex');
    Route::post('/dashboard_humint/grap_detail_risk_source', 'DashboardHumintController@grapDetailRiskSource');
    Route::post('/dashboard_humint/grap_detail_assets', 'DashboardHumintController@grapDetailAssets');
    Route::post('/dashboard_humint/grap_detail_risk', 'DashboardHumintController@grapDetailRisk');
});
