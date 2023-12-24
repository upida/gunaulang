<?php

use App\Http\Controllers\AuthController; 
use App\Http\Controllers\CartController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [HomeController::class, 'home_page'])->name('home.page');
Route::get('/search', [HomeController::class, 'search_page'])->name('search.page');
Route::get('/login', [AuthController::class, 'login_page'])->name('login.page');
Route::get('/register', [AuthController::class, 'register_page'])->name('register.page');

Route::group(['prefix' => '/user', 'as' => 'user.'], function() {
    Route::get('', [UserController::class, 'user_page'])->name('page');
    Route::get('/setting', [UserController::class, 'setting_page'])->name('setting.page');
    
    Route::group(['prefix' => '/history', 'as' => 'history.'], function() {
        Route::get('', [HistoryController::class, 'history_page'])->name('page');
        Route::get('/{order_id}', [HistoryController::class, 'detail_page'])->name('detail.page');
    });

    Route::group(['prefix' => '/cart', 'as' => 'cart.'], function() {
        Route::get('', [CartController::class, 'cart_page'])->name('page');
    });
    
    Route::group(['prefix' => '/order', 'as' => 'order.'], function() {
        Route::get('', [OrderController::class, 'order_page'])->name('page');
        Route::get('/shipment', [OrderController::class, 'shipment_page'])->name('shipment.page');
        Route::get('/verification', [OrderController::class, 'verification_page'])->name('verification.page');
    });
});

Route::group(['prefix' => '/{store_name}', 'as' => 'store.'], function() {
    Route::get('', [StoreController::class, 'store_page'])->name('page');
    Route::get('/search', [ProductController::class, 'search_page'])->name('search.page');
    Route::get('/{product_title}', [ProductController::class, 'product_page'])->name('product.page');
});