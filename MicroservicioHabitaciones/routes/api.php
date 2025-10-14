<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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

Route::middleware(['room'])->group(function () {

    Route::get('/rooms', [RoomsController::class, 'index']);
    Route::get('/rooms/{room}', [RoomsController::class, 'show']);
    Route::post('/rooms', [RoomsController::class, 'store']);
    Route::put('/rooms/{room}', [RoomsController::class, 'update']);
    Route::delete('/rooms/{room}', [RoomsController::class, 'destroy']);
    
});

