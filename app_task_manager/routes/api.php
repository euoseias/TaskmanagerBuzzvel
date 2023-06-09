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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('list', 'ManagerController');

//Route::get('/list', [ManagerController::class,'index']);

//Route::post('/list', [ManagerController::class,'store']);

//Route::get('/list/{id}', [ManagerController::class,'show']);

//Route::post('/list/{id}', [ManagerController::class,'update']);

//Route::get('/list/{id}', [ManagerController::class,'destroy']);




