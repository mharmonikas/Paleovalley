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

Route::middleware('auth:sanctum')->group(function() {
    Route::prefix('products')->group(function() {
        Route::post('', 'App\Http\Controllers\ProductsController@store');
        Route::put('{id}', 'App\Http\Controllers\ProductsController@update');
        Route::delete('{id}', 'App\Http\Controllers\ProductsController@destroy');
    });

});

Route::get('/products/{id}', 'App\Http\Controllers\ProductsController@index');
