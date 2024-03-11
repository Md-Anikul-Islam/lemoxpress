<?php

use App\Http\Controllers\api\DriverController;
use App\Http\Controllers\api\FleetSearchController;
use App\Http\Controllers\api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/fleet', [FleetSearchController::class, 'allFleet']);
Route::get('/fleet-search/{fleet_type}', [FleetSearchController::class, 'search']);

//Driver
Route::post('/drivers', [DriverController::class, 'storeDriver']);
Route::post('/driver-login', [DriverController::class, 'loginDriver']);
Route::post('/drivers-history', [DriverController::class, 'storeDriverHistory']);
Route::get('/get-drivers-history/{did}', [DriverController::class, 'getDriverHistory']);

//User
Route::post('/user-register', [UserController::class, 'storeUser']);
Route::post('/user-login', [UserController::class, 'loginUser']);
Route::post('/user-history', [UserController::class, 'storeUserHistory']);
