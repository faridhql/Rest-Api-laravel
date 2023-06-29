<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\OrderController;
use Illuminate\Auth\Events\Logout;
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
Route::post('/register', [AuthController::class ,'register']);

Route::post('/login', [AuthController::class ,'login']);

Route::middleware('auth:sanctum')->group(function () {

Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/listmenu',[MenuController::class ,'index']);

Route::post('/order',[OrderController::class ,'create']);

Route::get('/order',[OrderController::class ,'getOrder']);

Route::get('/order/{orderId}',[OrderController::class ,'getOrder']);

Route::delete('/order/{orderId}',[OrderController::class ,'destroy']);




});

