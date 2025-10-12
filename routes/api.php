<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'App\Http\Controllers\Api\Posts', 'prefix' => 'posts',], function () {
    Route::get('/', 'IndexController')->name('api.posts.index');
    Route::get('/{slug}', 'ShowController')->name('api.posts.show');
});
Route::group(['namespace' => 'App\Http\Controllers\Api\Games', 'prefix' => 'games',], function () {
    Route::get('/', 'IndexController')->name('api.games.index');
});
Route::group(['namespace' => 'App\Http\Controllers\Api\Seats', 'prefix' => 'seats',], function () {
    Route::get('/{match}', 'IndexController')->name('api.seats.index');
});
Route::middleware('auth:sanctum')->group(function () {
    Route::group(['namespace' => 'App\Http\Controllers\Api\Orders', 'prefix' => 'orders',], function () {
        Route::get('/', 'IndexController')->name('api.orders.index');
        Route::post('/', 'StoreController')->name('api.orders.store');
    });
});
