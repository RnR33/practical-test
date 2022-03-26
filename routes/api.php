<?php

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('/register', [\App\Http\Controllers\UserAuthController::class,'register']);
Route::post('/login', [\App\Http\Controllers\UserAuthController::class,'login']);
Route::post('/logout',[\App\Http\Controllers\UserAuthController::class,'logoutApi']);

Route::middleware('auth:api')->group(function () {

    Route::ApiResource('customer', \App\Http\Controllers\CustomerController::class);

});
