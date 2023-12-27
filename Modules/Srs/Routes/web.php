<?php

Route::prefix('srs')->middleware(['is_login_isec','prevent-back-history'])->group(function() {
    // DASHBOARD SRS
    Route::get('/dashboard', 'DashboardV2Controller@index'); //->middleware('is_login_isec');
    Route::post('/dashboard/grap_srs', 'DashboardV2Controller@grap_srs');
    Route::post('/dashboard/grap_detail_risk_source', 'DashboardV2Controller@grapDetailRiskSource');
    Route::post('/dashboard/grap_detail_assets', 'DashboardV2Controller@grapDetailAssets');
    Route::post('/dashboard/grap_detail_risk', 'DashboardV2Controller@grapDetailRisk');
    Route::post('/dashboard/grap_trend_soi', 'DashboardV2Controller@grapTrendSoi');
    Route::post('/dashboard/grap_top_index', 'DashboardV2Controller@grapTopIndex');
    Route::post('/dashboard/grap_risksource_soi', 'DashboardV2Controller@grapRiskSourceSoi');
    
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
    Route::get('/dashboard_humint', 'HumintDashboardV2Controller@index');
    Route::post('/dashboard_humint/soiIndexResiko', 'HumintDashboardV2Controller@soiIndexResiko'); 
    Route::post('/dashboard_humint/humintTransPlant', 'HumintDashboardV2Controller@humintTransPlant');
    Route::post('/dashboard_humint/riskTransSource', 'HumintDashboardV2Controller@riskTransSource');
    Route::post('/dashboard_humint/grap_srs', 'HumintDashboardV2Controller@grapReload');
    Route::post('/dashboard_humint/grap_trend_soi', 'HumintDashboardV2Controller@grapTrendSoi');
    Route::post('/dashboard_humint/grap_top_index', 'HumintDashboardV2Controller@grapTopIndex');
    Route::post('/dashboard_humint/grap_detail_risk_source', 'HumintDashboardV2Controller@grapDetailRiskSource');
    Route::post('/dashboard_humint/grap_detail_assets', 'HumintDashboardV2Controller@grapDetailAssets');
    Route::post('/dashboard_humint/grap_detail_risk', 'HumintDashboardV2Controller@grapDetailRisk');

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

    Route::get('/humint_source/srsExportReportPdf', 'HumintController@srsExportReportPdf');
    Route::get('/humint_source/export_excel', 'HumintController@exportExcel');
    Route::get('/humint_source', 'HumintController@index');
    Route::post('/humint_source/list_table', 'HumintController@listTable');
    Route::post('/humint_source/save', 'HumintController@saveData');
    Route::post('/humint_source/update', 'HumintController@updateData');
    Route::get('/humint_source/edit/{id}', 'HumintController@edit');
    Route::post('/humint_source/approve', 'HumintController@approve');
    Route::post('/humint_source/detail', 'HumintController@detail');
    Route::post('/humint_source/delete', 'HumintController@delete');
    Route::post('/humint_source/delete_attached', 'HumintController@deleteAttached');
    Route::post('/humint_source/search', 'HumintController@search');
    Route::post('/humint_source/detail_search', 'HumintController@detailSearch');
    Route::post('/humint_source/get_sub_area2', 'HumintController@getSubArea2');
    Route::post('/humint_source/get_sub_area3', 'HumintController@getSubArea3');
    Route::post('/humint_source/get_sub_assets', 'HumintController@getSubAssets');
    Route::post('/humint_source/get_sub_assets2', 'HumintController@getSubAssets2');
    Route::post('/humint_source/get_sub_risksource', 'HumintController@getSubRisksource');
    Route::post('/humint_source/get_sub_risksource2', 'HumintController@getSubRiskSource2');
    Route::post('/humint_source/get_sub_risk', 'HumintController@getSubRisk');
    Route::post('/humint_source/get_sub_risk2', 'HumintController@getSubRisk2');
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

    Route::get('/osint_source', 'OsintController@index');
    Route::get('/osint_source/edit/{id?}', 'OsintController@edit');
    Route::post('/osint_source/list_table', 'OsintController@listTable');
    Route::post('/osint_source/save', 'OsintController@saveData');
    Route::post('/osint_source/update', 'OsintController@updateData');
    Route::post('/osint_source/detail', 'OsintController@detail');
    Route::post('/osint_source/search', 'OsintController@search');
    Route::post('/osint_source/delete_attached', 'OsintController@deleteattached');
    Route::post('/osint_source/delete', 'OsintController@deleteData');
    Route::post('/osint_source/get_subArea', 'OsintController@getSubArea');
    Route::post('/osint_source/get_subArea1', 'OsintController@getSubArea1');
    Route::post('/osint_source/get_Issue', 'OsintController@getIssue');
    Route::post('/osint_source/get_SubIssue', 'OsintController@getSubIssue');
    Route::post('/osint_source/get_SubIssue1', 'OsintController@getSubIssue1');
    Route::post('/osint_source/get_riskSource', 'OsintController@getRiskSource');
    Route::post('/osint_source/get_riskSource1', 'OsintController@getRiskSource1');
    Route::post('/osint_source/get_issuMedia', 'OsintController@getIssuMedia');
    Route::post('/osint_source/get_SubissuMedia', 'OsintController@getSubissuMedia');
    Route::post('/osint_source/get_SubissuMedia1', 'OsintController@getSubissuMedia1');
    Route::post('/osint_source/getCategorySub1', 'OsintController@getCategorySub1');
    Route::post('/osint/detail', 'OsintController@detail');
    
    Route::post('/osint_profile/search', 'OsintProfileController@search');
    Route::get('/osint_profile/search_test', 'OsintProfileController@searchTest');
    // OSINT //
    
    // SOI
    Route::get('/dashboard_soi', 'soiDashboardController@index');
    Route::post('dashboard_soi/soi_avg_pilar', 'soiDashboardController@soiAvgPilar');
    Route::post('dashboard_soi/soi_avg_month', 'soiDashboardController@soiAvgMonth');
    Route::post('dashboard_soi/soi_avg_area_month', 'soiDashboardController@soiAvgAreaMonth');
    Route::post('dashboard_soi/soi_avg_area_pillar', 'soiDashboardController@soiAvgAreaPillar');
    Route::post('dashboard_soi/soi_threat_soi', 'soiDashboardController@soiThreatSoi');

    Route::get('/soi', 'SoiController@index');
    Route::post('/soi/list_table', 'SoiController@listTable');
    Route::post('/soi/get_performance_gt ', 'SoiController@getPerformanceGt');
    Route::post('/soi/detail', 'SoiController@detailData');
    Route::post('/soi/approve', 'SoiController@approveData');
    Route::post('/soi/save', 'SoiController@saveData');
    Route::post('/soi/delete', 'SoiController@deleteData');
    Route::get('/soi/edit/{id}', 'SoiController@edit');
    Route::post('/soi/update', 'SoiController@updateData');
    // SOI //
});
