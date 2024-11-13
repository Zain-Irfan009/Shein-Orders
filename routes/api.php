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
Route::any('/cartOrders', [\App\Http\Controllers\admin\AdminController::class, 'cartOrder']);
Route::any('/discount', [\App\Http\Controllers\admin\AdminController::class, 'discount']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
