<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\DashboardController;

// Route::get('/', function () {
//     return view('login');
// });

Route::get('/', [AuthController::class, 'index']);
// Route::get('/dashboard', [DashboardController::class, 'show']);

Route::prefix("auth")->group(function () {
    // Route::get("/", [AuthController::class, "index"])->name("auth.login");
    Route::post("/check", [AuthController::class, "check"])->name("auth.login");
    Route::get("/logout", [AuthController::class, "logout"])->name("auth.logout")->middleware(['is_login_isec','prevent-back-history']);
    Route::get("/out", [LoginController::class, "out"])->name("auth.out");
    Route::post("/verif", [LoginController::class, "post"])->name("auth.verif");
});

Route::middleware(['is_login_isec','prevent-back-history'])->group(function () {
    Route::get('/menu', [MenuController::class, 'index']);
});