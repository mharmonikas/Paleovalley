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

Route::prefix('products')->group(function() {
    Route::post('', 'App\Http\Controllers\ProductsController@store')->middleware(['auth:sanctum', 'ability:products:create']);
    Route::put('{id}', 'App\Http\Controllers\ProductsController@update')->middleware(['auth:sanctum', 'ability:products:update']);
    Route::delete('{id}', 'App\Http\Controllers\ProductsController@destroy')->middleware(['auth:sanctum', 'ability:products:delete']);
});

Route::get('/products/{id}', 'App\Http\Controllers\ProductsController@index');

Route::post('/login', 'App\Http\Controllers\Auth\AuthController@login');
