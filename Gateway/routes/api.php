<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutenticationController;
use App\Http\Controllers\RoomsController;

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
    Route::get('/rooms', [RoomsController::class, 'index']);
    Route::get('/rooms/{room}', [RoomsController::class, 'show']);
    Route::post('/rooms', [RoomsController::class, 'store']);
    Route::put('/rooms/{room}', [RoomsController::class, 'update']);
    Route::delete('/rooms/{room}', [RoomsController::class, 'destroy']);
    
    
});