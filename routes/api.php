<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login',[AuthController::class,'login']);
Route::get('/user/register/{email?}',[UserController::class,'signup']);
Route::post('/user/register/{email?}',[UserController::class,'store']);
Route::post('/confirm/{email}',[UserController::class,'confirm']);

Route::middleware(['auth:sanctum'])->group(function(){

    Route::post('/invite',[InvitationController::class,'invite']);
    Route::post('/logout',[AuthController::class,'logout']);
    Route::post('/user/update/{id}',[UserController::class,'update']);

});
