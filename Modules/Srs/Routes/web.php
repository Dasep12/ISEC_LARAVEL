<?php

Route::prefix('srs')->middleware(['is_login_isec', 'prevent-back-history'])->group(function () {
    // DASHBOARD SRS
    Route::get('/dashboard', 'DashboardController@index'); //->middleware('is_login_isec');
    Route::post('/dashboard/grap_srs', 'DashboardController@grap_srs');
    Route::post('/dashboard/grap_detail_risk_source', 'DashboardController@grapDetailRiskSource');
    Route::post('/dashboard/grap_detail_assets', 'DashboardController@grapDetailAssets');
    Route::post('/dashboard/grap_detail_risk', 'DashboardController@grapDetailRisk');
    Route::post('/dashboard/grap_trend_soi', 'DashboardController@grapTrendSoi');
    Route::post('/dashboard/grap_top_index', 'DashboardController@grapTopIndex');
    Route::post('/dashboard/grap_risksource_soi', 'DashboardController@grapRiskSourceSoi');

    Route::get('/dashboard_v2', 'DashboardV2Controller@index');
    Route::post('/dashboard_v2/grap_srs', 'DashboardV2Controller@grap_srs');
    Route::post('/dashboard_v2/grap_detail_risk_source', 'DashboardV2Controller@grapDetailRiskSource');
    Route::post('/dashboard_v2/grap_detail_assets', 'DashboardV2Controller@grapDetailAssets');
    Route::post('/dashboard_v2/grap_detail_risk', 'DashboardV2Controller@grapDetailRisk');
    Route::post('/dashboard_v2/grap_trend_soi', 'DashboardV2Controller@grapTrendSoi');
    Route::post('/dashboard_v2/grap_top_index', 'DashboardV2Controller@grapTopIndex');
    Route::post('/dashboard_v2/grap_risksource_soi', 'DashboardV2Controller@grapRiskSourceSoi');
    Route::post('/dashboard_v2/detail_event_list', 'DashboardV2Controller@detailEventList');
    // DASHBOARD SRS //

    // HUMINT
    Route::get('/dashboard_humint_v2', 'HumintDashboardV2Controller@index');
    Route::post('/dashboard_humint_v2/soiIndexResiko', 'HumintDashboardV2Controller@soiIndexResiko');
    Route::post('/dashboard_humint_v2/humintTransPlant', 'HumintDashboardV2Controller@humintTransPlant');
    Route::post('/dashboard_humint_v2/riskTransSource', 'HumintDashboardV2Controller@riskTransSource');
    Route::post('/dashboard_humint_v2/grap_srs', 'HumintDashboardV2Controller@grapReload');
    Route::post('/dashboard_humint_v2/grap_trend_soi', 'HumintDashboardV2Controller@grapTrendSoi');
    Route::post('/dashboard_humint_v2/grap_top_index', 'HumintDashboardV2Controller@grapTopIndex');
    Route::post('/dashboard_humint_v2/grap_detail_risk_source', 'HumintDashboardV2Controller@grapDetailRiskSource');
    Route::post('/dashboard_humint_v2/grap_detail_assets', 'HumintDashboardV2Controller@grapDetailAssets');
    Route::post('/dashboard_humint_v2/grap_detail_risk', 'HumintDashboardV2Controller@grapDetailRisk');

    Route::get('/internal_source', 'InternalsourceController@index');
    Route::post('/internal_source/list_table', 'InternalsourceController@listTable');
    Route::post('/internal_source/save', 'InternalsourceController@saveForm');
    Route::get('/internal_source/edit/{id}', 'InternalsourceController@edit');
    Route::post('/internal_source/detail', 'InternalsourceController@detail');
    Route::post('/internal_source/search', 'InternalsourceController@search');
    Route::post('/internal_source/detail_search', 'InternalsourceController@detailSearch');
    Route::post('/internal_source/get_sub_area2', 'InternalsourceController@getSubArea2');
    Route::post('/internal_source/get_sub_area3', 'InternalsourceController@getSubArea3');
    Route::post('/internal_source/get_sub_assets', 'InternalsourceController@getSubAssets');
    Route::post('/internal_source/get_sub_assets2', 'InternalsourceController@getSubAssets2');
    Route::post('/internal_source/get_sub_risksource', 'InternalsourceController@getSubRisksource');
    Route::post('/internal_source/get_sub_risksource2', 'InternalsourceController@getSubRiskSource2');
    Route::post('/internal_source/get_sub_risk', 'InternalsourceController@getSubRisk');
    Route::post('/internal_source/get_sub_risk2', 'InternalsourceController@getSubRisk2');
    // HUMINT //

    // OSINT
    Route::get('/dashboard_osint', 'OsintDashboardController@index');
    Route::post('/dashboard_osint/getAllDataPie', 'OsintDashboardController@getAllDataPie');
    Route::post('/dashboard_osint/getArea', 'OsintDashboardController@getArea');
    Route::post('/dashboard_osint/detail_event_list', 'OsintDashboardController@detailEventList');
    Route::post('/dashboard_osint/getInternalSource', 'OsintDashboardController@getInternalSource');
    Route::post('/dashboard_osint/getExternalSource', 'OsintDashboardController@getExternalSource');
    Route::post('/dashboard_osint/detailSource', 'OsintDashboardController@detailSource');
    Route::post('/dashboard_osint/getTargetAssets', 'OsintDashboardController@getTargetAssets');
    Route::post('/dashboard_osint/detailTargetAssets', 'OsintDashboardController@detailTargetAssets');
    Route::post('/dashboard_osint/getNegativeSentiment', 'OsintDashboardController@getNegativeSentiment');
    Route::post('/dashboard_osint/detailNegativeSentiment', 'OsintDashboardController@detailNegativeSentiment');
    Route::post('/dashboard_osint/getMedia', 'OsintDashboardController@getMedia');
    Route::post('/dashboard_osint/detailMedia', 'OsintDashboardController@detailMedia');
    Route::post('/dashboard_osint/getFormat', 'OsintDashboardController@getFormat');
    Route::post('/dashboard_osint/detailFormat', 'OsintDashboardController@detailFormat');
    Route::post('/dashboard_osint/totalLevelAvg', 'OsintDashboardController@totalLevelAvg');

    Route::post('/osint/detail', 'OsintController@detail');
    // OSINT //

    // SOI
    Route::get('/dashboard_soi', 'soiDashboardController@index');
    Route::post('dashboard_soi/soi_avg_pilar', 'soiDashboardController@soiAvgPilar');
    Route::post('dashboard_soi/soi_avg_month', 'soiDashboardController@soiAvgMonth');
    Route::post('dashboard_soi/soi_avg_area_month', 'soiDashboardController@soiAvgAreaMonth');
    Route::post('dashboard_soi/soi_avg_area_pillar', 'soiDashboardController@soiAvgAreaPillar');
    Route::post('dashboard_soi/soi_threat_soi', 'soiDashboardController@soiThreatSoi');
    // SOI //
});
