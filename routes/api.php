<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProductsController;
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

Route::prefix('products')->group(function() {
    Route::get('{id}', [ProductsController::class, 'index']);
    Route::post('', [ProductsController::class, 'store'])->middleware(['auth:sanctum', 'ability:products:create']);
    Route::put('{id}', [ProductsController::class, 'update'])->middleware(['auth:sanctum', 'ability:products:update']);
    Route::delete('{id}', [ProductsController::class, 'destroy'])->middleware(['auth:sanctum', 'ability:products:delete']);
});

Route::post('/login', [AuthController::class, 'login']);
