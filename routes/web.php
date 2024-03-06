<?php

use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\FleetController;
use App\Http\Controllers\admin\FleetTypeController;
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
});
require __DIR__.'/auth.php';
