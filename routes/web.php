<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsersController;

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

Route::get('/maps', [DashboardController::class, "maps"]);

Route::middleware("is_login_isec")->group(function () {
    Route::get('/menu', [MenuController::class, 'index']);
    Route::post('/menu/srsSoi', [MenuController::class, 'srsSoi']);
    Route::post('/menu/srsMonth', [MenuController::class, 'srsMonth']);
    Route::post('/menu/srsPerPlant', [MenuController::class, 'srsPerPlant']);
    Route::post('/menu/srsRiskSource', [MenuController::class, 'srsRiskSource']);
    Route::post('/menu/srsTargetAssets', [MenuController::class, 'srsTargetAssets']);
    Route::post('/menu/srsRisk', [MenuController::class, 'srsRisk']);


    Route::get('/Setting/Pengguna/list_user', [UsersController::class, 'index']);
    Route::get('/Setting/Pengguna/register', [UsersController::class, 'register']);
    Route::post('/Setting/Pengguna/input', [UsersController::class, 'input']);
    Route::post('/Setting/Pengguna/getPlants', [UsersController::class, 'getPlants']);
    Route::post('/Setting/Pengguna/resetPasword', [UsersController::class, 'getPlants']);
});
