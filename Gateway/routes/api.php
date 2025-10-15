<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutenticationController;
use App\Http\Controllers\RoomsController;
use App\Http\Controllers\ReservationsController;

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

Route::post('login', [AutenticationController::class, 'login']);
Route::post('register', [AutenticationController::class, 'register']);

Route::middleware('auth:api', 'role:Admin|Recepcionista|Cliente')->group(function () {
    Route::post('logout', [AutenticationController::class, 'logout']);
});

Route::middleware('auth:api', 'role:Admin')->group(function () {

    /*---------------Rooms----------------------------*/
    
    Route::post('/rooms', [RoomsController::class, 'store']);
    Route::put('/rooms/{room}', [RoomsController::class, 'update']);
    Route::delete('/rooms/{room}', [RoomsController::class, 'destroy']);
    Route::get('/report', [ReservationsController::class, 'createReport']);
    
    
});

Route::middleware('auth:api', 'role:Admin|Recepcionista')->group(function () {

    
    Route::get('/rooms', [RoomsController::class, 'index']);
    Route::get('/reservations', [ReservationsController::class, 'index']);
    Route::get('/rooms/{room}', [RoomsController::class, 'show']);
    Route::get('/reservations/{reservation}', [ReservationsController::class, 'show']);
    Route::post('/reservations', [ReservationsController::class, 'store']);
    Route::put('/reservations/{reservation}', [ReservationsController::class, 'update']);
    Route::delete('/reservations/{reservation}', [ReservationsController::class, 'destroy']);
    
    
});

Route::middleware('auth:api', 'role:Cliente')->group(function () {
    
    Route::get('/roomsUser', [RoomsController::class, 'index']);
    Route::post('/reservationsUser', [ReservationsController::class, 'storeUser']);
    Route::get('/reservationsUser', [ReservationsController::class, 'showUser']);
    Route::delete('/reservationsUser/{id}', [ReservationsController::class, 'destroyUser']);
    
});