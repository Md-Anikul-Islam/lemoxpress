<?php

use App\Http\Controllers\admin\CouponController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\DriverController;
use App\Http\Controllers\admin\FleetController;
use App\Http\Controllers\admin\FleetTypeController;
use App\Http\Controllers\admin\TollController;
use App\Http\Controllers\admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});

//Admin
Route::middleware('auth')->group(callback: function () {
    //Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //Fleet Type Section
    Route::get('/fleet-type-section', [FleetTypeController::class, 'index'])->name('fleet.type.section');
    Route::post('/fleet-type-store', [FleetTypeController::class, 'store'])->name('fleet.type.store');
    Route::put('/fleet-type-update/{id}', [FleetTypeController::class, 'update'])->name('fleet.type.update');
    Route::get('/fleet-type-delete/{id}', [FleetTypeController::class, 'destroy'])->name('fleet.type.destroy');

    //Fleet Section
    Route::get('/fleet-section', [FleetController::class, 'index'])->name('fleet.section');
    Route::post('/fleet-store', [FleetController::class, 'store'])->name('fleet.store');
    Route::put('/fleet-update/{id}', [FleetController::class, 'update'])->name('fleet.update');
    Route::get('/fleet-delete/{id}', [FleetController::class, 'destroy'])->name('fleet.destroy');


    //Coupon Section
    Route::get('/coupon-section', [CouponController::class, 'index'])->name('coupon.section');
    Route::post('/coupon-store', [CouponController::class, 'store'])->name('coupon.store');
    Route::put('/coupon-update/{id}', [CouponController::class, 'update'])->name('coupon.update');
    Route::get('/coupon-delete/{id}', [CouponController::class, 'destroy'])->name('coupon.destroy');

    //Toll Section
    Route::get('/toll-section', [TollController::class, 'index'])->name('toll.section');
    Route::post('/toll-store', [TollController::class, 'store'])->name('toll.store');
    Route::put('/toll-update/{id}', [TollController::class, 'update'])->name('toll.update');
    Route::get('/toll-delete/{id}', [TollController::class, 'destroy'])->name('toll.destroy');

    //Driver Section
    Route::get('/driver-list', [DriverController::class, 'driverList'])->name('driver.list');
    Route::put('/driver-update/{id}', [DriverController::class, 'update'])->name('driver.update');
    Route::get('/driver-history/{id}', [DriverController::class, 'driverHistpry'])->name('driver.history');

    //User Section
    Route::get('/user-list', [UserController::class, 'userList'])->name('user.list');
    Route::get('/user-history/{id}', [UserController::class, 'userHistpry'])->name('user.history');
});
require __DIR__.'/auth.php';
