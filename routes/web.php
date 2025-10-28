<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Стандартная Laravel авторизация
Auth::routes();

// Админ-панель
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', \App\Http\Controllers\Admin\DashboardController::class)->name('dashboard');

    // Posts (Новости) - ГОТОВО!
    Route::group(['namespace' => 'App\Http\Controllers\Admin\Posts', 'prefix' => 'posts', 'as' => 'posts.'], function () {
        Route::get('/', 'IndexController')->name('index');
        Route::get('/create', 'CreateController')->name('create');
        Route::post('/', 'StoreController')->name('store');
        Route::get('/{post}', 'ShowController')->name('show');
        Route::get('/{post}/edit', 'EditController')->name('edit');
        Route::put('/{post}', 'UpdateController')->name('update');
        Route::delete('/{post}', 'DestroyController')->name('destroy');
    });

    // Games (Матчи) - ГОТОВО!
    Route::group(['namespace' => 'App\Http\Controllers\Admin\Games', 'prefix' => 'games', 'as' => 'games.'], function () {
        Route::get('/', 'IndexController')->name('index');
        Route::get('/create', 'CreateController')->name('create');
        Route::post('/', 'StoreController')->name('store');
        Route::get('/{game}', 'ShowController')->name('show');
        Route::get('/{game}/edit', 'EditController')->name('edit');
        Route::put('/{game}', 'UpdateController')->name('update');
        Route::delete('/{game}', 'DestroyController')->name('destroy');
    });
//
//
//    // Stadiums (Стадионы)
    Route::group(['namespace' => 'App\Http\Controllers\Admin\Stadiums', 'prefix' => 'stadiums', 'as' => 'stadiums.'], function () {
        Route::get('/', 'IndexController')->name('index');
        Route::get('/create', 'CreateController')->name('create');
        Route::post('/', 'StoreController')->name('store');
        Route::get('/{stadium}', 'ShowController')->name('show');
        Route::get('/{stadium}/edit', 'EditController')->name('edit');
        Route::put('/{stadium}', 'UpdateController')->name('update');
        Route::delete('/{stadium}', 'DestroyController')->name('destroy');
    });

    // Stadium Schemes (Схемы стадионов)
    Route::group(['namespace' => 'App\Http\Controllers\Admin\StadiumSchemes', 'prefix' => 'stadium-schemes', 'as' => 'stadium-schemes.'], function () {
        Route::get('/', 'IndexController')->name('index');
        Route::get('/upload', 'UploadController')->name('upload');
        Route::post('/', 'StoreController')->name('store');
        Route::get('/{stadium}/preview', 'PreviewController')->name('preview');
        Route::get('/{stadium}/edit', 'EditController')->name('edit');
        Route::put('/{stadium}', 'UpdateController')->name('update');
    });

    // Orders (Заказы)
    Route::group(['namespace' => 'App\Http\Controllers\Admin\Orders', 'prefix' => 'orders', 'as' => 'orders.'], function () {
        Route::get('/', 'IndexController')->name('index');
        Route::get('/{order}', 'ShowController')->name('show');
        Route::get('/{order}/edit', 'EditController')->name('edit');
        Route::put('/{order}', 'UpdateController')->name('update');
    });

    // Tickets (Билеты)
    Route::group(['namespace' => 'App\Http\Controllers\Admin\Tickets', 'prefix' => 'tickets', 'as' => 'tickets.'], function () {
        Route::get('/', 'IndexController')->name('index');
        Route::get('/{game}', 'GameTicketsController')->name('game-tickets');
        Route::get('/view/{ticket}', 'ShowController')->name('show');
    });
//
//
//    // Users (Пользователи) - TODO
//
//    Route::group(['namespace' => 'App\Http\Controllers\Admin\Users', 'prefix' => 'users', 'as' => 'users.'], function () {
//        Route::get('/', 'IndexController')->name('admin.users.index');
//        Route::get('/create', 'CreateController')->name('admin.users.create');
//        Route::post('/', 'StoreController')->name('admin.users.store');
//        Route::get('/{user}', 'ShowController')->name('admin.users.show');
//        Route::get('/{user}/edit', 'EditController')->name('admin.users.edit');
//        Route::put('/{user}', 'UpdateController')->name('admin.users.update');
//        Route::delete('/{user}', 'DestroyController')->name('admin.users.destroy');
//    });

});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
