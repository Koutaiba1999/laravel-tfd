<?php

use App\Http\Controllers\StockController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('register', [UserController::class, 'store']);
    Route::post("login", [UserController::class, 'login']);
    Route::post('me', [UserController::class, 'me']);
});
Route::group(['middleware' => 'api', 'prefix' => 'stock'], function ($router) {
    Route::post('addStock', [StockController::class, 'storeproduct']);
    Route::get('getStock', [StockController::class, 'getallstock']);

});
