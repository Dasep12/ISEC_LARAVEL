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

use Modules\GuardTour\Http\Controllers\CheckpointController;
use Modules\GuardTour\Http\Controllers\CompanyController;
use Modules\GuardTour\Http\Controllers\PlantsController;
use Modules\GuardTour\Http\Controllers\SiteController;
use Modules\GuardTour\Http\Controllers\ZoneController;
use Modules\GuardTour\Http\Controllers\DashboardController;
use Modules\GuardTour\Http\Controllers\KategoriController;
use Modules\GuardTour\Http\Controllers\ObjekController;
use Modules\GuardTour\Http\Controllers\EventController;
use Modules\GuardTour\Http\Controllers\JadPatroliController;
use Modules\GuardTour\Http\Controllers\JadProduksiController;
use Modules\GuardTour\Http\Controllers\ProduksiController;
use Modules\GuardTour\Http\Controllers\RoleController;
use Modules\GuardTour\Http\Controllers\SettingsController;
use Modules\GuardTour\Http\Controllers\ShiftController;
use Modules\GuardTour\Http\Controllers\UsersController;
use Modules\GuardTour\Http\Controllers\UsersGaController;

Route::prefix('guardtour')->group(function () {

    // dashboard
    Route::get('/dashboard', [DashboardController::class, "index"])->name('dashboard');


    //master company    
    Route::get('/company/master', [CompanyController::class, "master"])->name('company.master');
    Route::get('/company/form_add', [CompanyController::class, "form_add"])->name('company.form_add');
    Route::post('/company/insert', [CompanyController::class, "insert"])->name('company.insert');
    Route::get('/company/destroy', [CompanyController::class, "destroy"])->name('company.destroy');
    Route::get('/company/form_edit', [CompanyController::class, "form_edit"])->name('company.form_edit');
    Route::post('/company/update', [CompanyController::class, "update"])->name('company.update');

    // master wilayah
    Route::get('/site/master', [SiteController::class, "master"])->name('site.master');
    Route::get('/site/form_add', [SiteController::class, "form_add"])->name('site.form_add');
    Route::post('/site/insert', [SiteController::class, "insert"])->name('site.insert');
    Route::get('/site/destroy', [SiteController::class, "destroy"])->name('site.destroy');
    Route::get('/site/form_edit', [SiteController::class, "form_edit"])->name('site.form_edit');
    Route::post('/site/update', [SiteController::class, "update"])->name('site.update');

    // master plant
    Route::get('/plant/master', [PlantsController::class, "master"])->name('plant.master');
    Route::get('/plant/form_add', [PlantsController::class, "form_add"])->name('plant.form_add');
    Route::post('/plant/insert', [PlantsController::class, "insert"])->name('plant.insert');
    Route::get('/plant/destroy', [PlantsController::class, "destroy"])->name('plant.destroy');
    Route::get('/plant/form_edit', [PlantsController::class, "form_edit"])->name('plant.form_edit');
    Route::post('/plant/update', [PlantsController::class, "update"])->name('plant.update');
    Route::post('/plant/getWilayah', [PlantsController::class, "getWilayah"])->name('plant.getWilayah');

    // master zone
    Route::get('/zona/master', [ZoneController::class, "master"])->name('zona.master');
    Route::get('/zona/form_add', [ZoneController::class, "form_add"])->name('zona.form_add');
    Route::post('/zona/insert', [ZoneController::class, "insert"])->name('zona.insert');
    Route::get('/zona/destroy', [ZoneController::class, "destroy"])->name('zona.destroy');
    Route::get('/zona/form_edit', [ZoneController::class, "form_edit"])->name('zona.form_edit');
    Route::post('/zona/update', [ZoneController::class, "update"])->name('zona.update');
    Route::post('/zona/getPlant', [ZoneController::class, "getPlant"])->name('zona.getPlant');

    // master checkpoint
    Route::get('/checkpoint/master', [CheckpointController::class, "master"])->name('checkpoint.master');
    Route::get('/checkpoint/form_add', [CheckpointController::class, "form_add"])->name('checkpoint.form_add');
    Route::post('/checkpoint/insert', [CheckpointController::class, "insert"])->name('checkpoint.insert');
    Route::get('/checkpoint/destroy', [CheckpointController::class, "destroy"])->name('checkpoint.destroy');
    Route::get('/checkpoint/form_edit', [CheckpointController::class, "form_edit"])->name('checkpoint.form_edit');
    Route::post('/checkpoint/update', [CheckpointController::class, "update"])->name('checkpoint.update');
    Route::post('/checkpoint/getZona', [CheckpointController::class, "getZona"])->name('checkpoint.getZona');


    // master kategori objek
    Route::get('/kategori_objek/master', [KategoriController::class, "master"])->name('kategori_objek.master');
    Route::get('/kategori_objek/form_add', [KategoriController::class, "form_add"])->name('kategori_objek.form_add');
    Route::post('/kategori_objek/insert', [KategoriController::class, "insert"])->name('kategori_objek.insert');
    Route::get('/kategori_objek/destroy', [KategoriController::class, "destroy"])->name('kategori_objek.destroy');
    Route::get('/kategori_objek/form_edit', [KategoriController::class, "form_edit"])->name('kategori_objek.form_edit');
    Route::post('/kategori_objek/update', [KategoriController::class, "update"])->name('kategori_objek.update');
    Route::post('/kategori_objek/getZona', [KategoriController::class, "getZona"])->name('kategori_objek.getZona');


    // master  objek
    Route::get('/objek/master', [ObjekController::class, "master"])->name('objek.master');
    Route::get('/objek/form_add', [ObjekController::class, "form_add"])->name('objek.form_add');
    Route::post('/objek/insert', [ObjekController::class, "insert"])->name('objek.insert');
    Route::get('/objek/destroy', [ObjekController::class, "destroy"])->name('objek.destroy');
    Route::get('/objek/form_edit', [ObjekController::class, "form_edit"])->name('objek.form_edit');
    Route::post('/objek/update', [ObjekController::class, "update"])->name('objek.update');
    Route::post('/objek/getZona', [ObjekController::class, "getZona"])->name('objek.getZona');
    Route::post('/objek/getCheckpoint', [ObjekController::class, "getCheckpoint"])->name('objek.getCheckpoint');

    // master  users
    Route::get('/users/master', [UsersController::class, "master"])->name('users.master');
    Route::get('/users/form_add', [UsersController::class, "form_add"])->name('users.form_add');
    Route::post('/users/insert', [UsersController::class, "insert"])->name('users.insert');
    Route::get('/users/destroy', [UsersController::class, "destroy"])->name('users.destroy');
    Route::get('/users/form_edit', [UsersController::class, "form_edit"])->name('users.form_edit');
    Route::post('/users/update', [UsersController::class, "update"])->name('users.update');
    Route::post('/users/getPlant', [UsersController::class, "getPlant"])->name('users.getPlant');


    // master  users_ga
    Route::get('/users_ga/master', [UsersGaController::class, "master"])->name('users_ga.master');
    Route::get('/users_ga/form_add', [UsersGaController::class, "form_add"])->name('users_ga.form_add');
    Route::post('/users_ga/insert', [UsersGaController::class, "insert"])->name('users_ga.insert');
    Route::get('/users_ga/destroy', [UsersGaController::class, "destroy"])->name('users_ga.destroy');
    Route::get('/users_ga/form_edit', [UsersGaController::class, "form_edit"])->name('users_ga.form_edit');
    Route::post('/users_ga/update', [UsersGaController::class, "update"])->name('users_ga.update');
    Route::post('/users_ga/getPlant', [UsersGaController::class, "getPlant"])->name('users_ga.getPlant');

    // master  role
    Route::get('/role/master', [RoleController::class, "master"])->name('role.master');
    Route::get('/role/form_add', [RoleController::class, "form_add"])->name('role.form_add');
    Route::post('/role/insert', [RoleController::class, "insert"])->name('role.insert');
    Route::get('/role/destroy', [RoleController::class, "destroy"])->name('role.destroy');
    Route::get('/role/form_edit', [RoleController::class, "form_edit"])->name('role.form_edit');
    Route::post('/role/update', [RoleController::class, "update"])->name('role.update');

    // master  event
    Route::get('/event/master', [EventController::class, "master"])->name('event.master');
    Route::get('/event/form_add', [EventController::class, "form_add"])->name('event.form_add');
    Route::post('/event/insert', [EventController::class, "insert"])->name('event.insert');
    Route::get('/event/destroy', [EventController::class, "destroy"])->name('event.destroy');
    Route::get('/event/form_edit', [EventController::class, "form_edit"])->name('event.form_edit');
    Route::post('/event/update', [EventController::class, "update"])->name('event.update');

    // master  shift
    Route::get('/shift/master', [ShiftController::class, "master"])->name('shift.master');
    Route::get('/shift/form_add', [ShiftController::class, "form_add"])->name('shift.form_add');
    Route::post('/shift/insert', [ShiftController::class, "insert"])->name('shift.insert');
    Route::get('/shift/destroy', [ShiftController::class, "destroy"])->name('shift.destroy');
    Route::get('/shift/form_edit', [ShiftController::class, "form_edit"])->name('shift.form_edit');
    Route::post('/shift/update', [ShiftController::class, "update"])->name('shift.update');

    //master produksi
    Route::get('/produksi/master', [ProduksiController::class, "master"])->name('produksi.master');
    Route::get('/produksi/form_add', [ProduksiController::class, "form_add"])->name('produksi.form_add');
    Route::post('/produksi/insert', [ProduksiController::class, "insert"])->name('produksi.insert');
    Route::get('/produksi/destroy', [ProduksiController::class, "destroy"])->name('produksi.destroy');
    Route::get('/produksi/form_edit', [ProduksiController::class, "form_edit"])->name('produksi.form_edit');
    Route::post('/produksi/update', [ProduksiController::class, "update"])->name('produksi.update');


    // master  setting
    Route::get('/settings/master', [SettingsController::class, "master"])->name('settings.master');
    Route::get('/settings/form_add', [SettingsController::class, "form_add"])->name('settings.form_add');
    Route::post('/settings/insert', [SettingsController::class, "insert"])->name('settings.insert');
    Route::get('/settings/destroy', [SettingsController::class, "destroy"])->name('settings.destroy');
    Route::get('/settings/form_edit', [SettingsController::class, "form_edit"])->name('settings.form_edit');
    Route::post('/settings/update', [SettingsController::class, "update"])->name('settings.update');


    // jadwal patroli
    Route::get('/jadpatroli/master', [JadPatroliController::class, "master"])->name('jadpatroli.master');
    Route::post('/jadpatroli/master', [JadPatroliController::class, "master"])->name('jadpatroli.master');
    Route::get('/jadpatroli/form_upload', [JadPatroliController::class, "form_upload"])->name('jadpatroli.form_upload');
    Route::get('/jadpatroli/form_edit_jadpatrol', [JadPatroliController::class, "edit_jadwal"])->name('jadpatroli.form_edit_jadpatrol');
    Route::post('/jadpatroli/form_edit_jadpatrol', [JadPatroliController::class, "edit_jadwal"])->name('jadpatroli.form_edit_jadpatrol');
    Route::post('/jadpatroli/updateJadwal', [JadPatroliController::class, "updateJadwal"])->name('jadpatroli.updateJadwal');
    Route::post('/jadpatroli/upload', [JadPatroliController::class, "uploadJadwal"])->name('jadpatroli.upload');



    // jadwal produksi
    Route::get('/jadproduksi/master', [JadProduksiController::class, "master"])->name('jadproduksi.master');
    Route::post('/jadproduksi/master', [JadProduksiController::class, "master"])->name('jadproduksi.master');
    Route::post('/jadproduksi/updateProduksi', [JadProduksiController::class, "updateProduksi"])->name('jadproduksi.updateProduksi');
    Route::get('/jadproduksi/form_upload', [JadProduksiController::class, "form_upload"])->name('jadproduksi.form_upload');
    Route::post('/jadproduksi/upload', [JadProduksiController::class, "uploadJadwal"])->name('jadproduksi.upload');
});
