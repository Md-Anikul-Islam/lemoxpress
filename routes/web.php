<?php

use App\Http\Controllers\admin\CouponController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\DriverController;
use App\Http\Controllers\admin\FleetController;
use App\Http\Controllers\admin\FleetTypeController;
use App\Http\Controllers\admin\TollController;
use App\Http\Controllers\admin\TripController;
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
Route::get('/get-specific-driver-trip-history/{encryptedId}', [DriverController::class, 'driverSpecificTripHistory']);
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
    Route::get('/pending-driver-list', [DriverController::class, 'pendingDriverList'])->name('pending.driver.list');
    Route::get('/suspend-driver-list', [DriverController::class, 'suspendDriverList'])->name('suspend.driver.list');
    Route::get('/driver-details/{id}', [DriverController::class, 'driverDetails'])->name('driver.details');

    Route::put('/driver-update/{id}', [DriverController::class, 'update'])->name('driver.update');
    Route::get('/driver-history/{id}', [DriverController::class, 'driverHistpry'])->name('driver.history');
    Route::get('/driver-trip-history/{id}', [DriverController::class, 'driverTripHistory'])->name('driver.trip.history');
    Route::get('/driver-delete/{id}', [DriverController::class, 'destroy'])->name('driver.destroy');
    //User Section
    Route::get('/user-list', [UserController::class, 'userList'])->name('user.list');
    Route::get('/user-history/{id}', [UserController::class, 'userHistory'])->name('user.history');

    //Manual Trip Section
    Route::get('/complete-trip-list', [TripController::class, 'index'])->name('complete.trip.list');
    Route::get('/incomplete-trip-list', [TripController::class, 'inComplete'])->name('incomplete.trip.list');

    //Request Trip Section
    Route::get('/request-trip-list', [TripController::class, 'requestTripList'])->name('request.trip.list');

});
require __DIR__.'/auth.php';
