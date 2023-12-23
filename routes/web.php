<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\setting\UserRoleAppController;
use App\Http\Controllers\setting\UserAreaController;
use App\Http\Controllers\setting\RoleModuleController;

// Route::get('/', function () {
//     return view('login');
// });

Route::get('/', [AuthController::class, 'index']);
// Route::get('/dashboard', [DashboardController::class, 'show']);

Route::prefix("auth")->group(function () {
    // Route::get("/", [AuthController::class, "index"])->name("auth.login");
    Route::post("/check", [AuthController::class, "check"])->name("auth.login");
    Route::get("/out", [LoginController::class, "out"])->name("auth.out");
    Route::post("/verif", [LoginController::class, "post"])->name("auth.verif");
});


Route::get('/logout', [AuthController::class, "logout"])->name("auth.logout");


Route::middleware("is_login_isec")->group(function () {
    Route::get('/menu', [MenuController::class, 'index']);
    Route::post('/menu/srsSoi', [MenuController::class, 'srsSoi']);
    Route::post('/menu/srsMonth', [MenuController::class, 'srsMonth']);
    Route::post('/menu/srsPerPlant', [MenuController::class, 'srsPerPlant']);
    Route::post('/menu/srsRiskSource', [MenuController::class, 'srsRiskSource']);
    Route::post('/menu/srsTargetAssets', [MenuController::class, 'srsTargetAssets']);
    Route::post('/menu/srsRisk', [MenuController::class, 'srsRisk']);

    Route::get('/setting/user_role_app/user_role_app', [UserRoleAppController::class, 'index']);
    Route::post('/setting/user_role_app/list_user_role_app', [UserRoleAppController::class, 'listTable']);
    Route::post('/setting/user_role_app/delete', [UserRoleAppController::class, 'delete']);

    Route::get('/setting/user_area', [UserAreaController::class, 'index']);
    Route::post('/setting/user_area/list', [UserAreaController::class, 'listTable']);
    Route::post('/setting/user_area/save', [UserAreaController::class, 'save']);
    Route::post('/setting/user_area/delete', [UserAreaController::class, 'delete']);

    Route::get('/setting/role_module', [RoleModuleController::class, 'index']);
    Route::post('/setting/role_module/list', [RoleModuleController::class, 'listTable']);
    Route::post('/setting/role_module/delete', [RoleModuleController::class, 'delete']);
    Route::post('/setting/role_module/edit', [RoleModuleController::class, 'edit']);
    Route::post('/setting/role_module/role_update', [RoleModuleController::class, 'roleUpdate']);
});
