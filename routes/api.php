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
    // ⚠️ ВАЖНО: Более специфичные маршруты должны быть ВЫШЕ общего маршрута /{id}
    // Иначе Laravel будет пытаться найти матч с id="sectors" и вернёт 404
    Route::get('/{id}/sectors', 'SectorsController')->name('api.games.sectors');
    Route::get('/{id}/sectors/{sectorId}/seats', 'SectorSeatsController')->name('api.games.sectors.seats');
    // Общий маршрут для детальной карточки матча - в конце
    Route::get('/{id}', 'ShowController')->name('api.games.show');
});
Route::group(['namespace' => 'App\Http\Controllers\Api\Seats', 'prefix' => 'seats',], function () {
    Route::get('/{match}', 'IndexController')->name('api.seats.index');
});
// Заказы - публичные эндпоинты (без авторизации для MVP)
Route::group(['namespace' => 'App\Http\Controllers\Api\Orders', 'prefix' => 'orders',], function () {
    Route::post('/', 'StoreController')->name('api.orders.store');
    // ⚠️ ВАЖНО: Специфичные маршруты должны быть ВЫШЕ общего /{id}
    Route::post('/{id}/cancel', 'CancelController')->name('api.orders.cancel');
    Route::post('/{id}/pay', 'PayController')->name('api.orders.pay');
    Route::get('/{id}', 'ShowController')->name('api.orders.show');
});

// Заказы пользователя - требуют авторизацию
Route::middleware('auth:sanctum')->group(function () {
    Route::group(['namespace' => 'App\Http\Controllers\Api\Orders', 'prefix' => 'orders',], function () {
        Route::get('/', 'IndexController')->name('api.orders.index');
    });
});
