<?php

use App\Http\Controllers\ResidentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VisitorHistoryController;
use App\Http\Controllers\VisitorController;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/residents', [ResidentController::class, 'getAllResidents']);
    Route::post('/send-visitor-data', [VisitorController::class, 'sendVisitorData']);
    Route::get('/visitors', [VisitorController::class, 'getAllVisitor']);
    Route::get('/visitors/{id}', [VisitorController::class, 'getVisitorById']);
    Route::put('/visitors/{id}', [VisitorController::class, 'changeVisitorStatus']);
    Route::post('/logout', [UserController::class, 'logout']);
    Route::post('/visitors', [VisitorController::class, 'get']);
    Route::get('/user', [UserController::class, 'fetchUser']);
});

Route::post('login', [UserController::class, 'login']);