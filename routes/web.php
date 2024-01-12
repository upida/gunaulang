<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\DonatorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/test', function() {
//     return Inertia::render('Test');
// })->name('test');

Route::get('/', [HomeController::class, 'page'])->name('home');

Route::get('/category', [HomeController::class, 'category_page'])->name('category');
Route::get('/search', [HomeController::class, 'search_page'])->name('search');
Route::get('/product/{product}', [HomeController::class, 'product_page'])->name('product');

Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::get('/cart', [CartController::class, 'page'])->name('cart');
    Route::post('/cart/{product}', [CartController::class, 'edit'])->name('cart.edit');
    
    Route::group(['prefix' => '/order', 'as' => 'order.'], function() {
        Route::get('/', [OrderController::class, 'list_page'])->name('list.page');
        
        Route::post('/checkout', [OrderController::class, 'checkout_page'])->name('checkout.page');
        Route::patch('/checkout', [OrderController::class, 'create'])->name('create');
        
        Route::get('/{order}', [OrderController::class, 'detail_page'])->name('detail.page');
        Route::patch('/{order}', [OrderController::class, 'update'])->name('update'); 
    });

    Route::group(['prefix' => '/donator', 'as' => 'donator.'], function () {
        Route::get('', [DonatorController::class, 'page'])->name('page');
        
        Route::get('/store', [DonatorController::class, 'store_page'])->name('store.page');
        Route::patch('/store', [DonatorController::class, 'store'])->name('store');
        
        Route::get('/donate', [DonatorController::class, 'donate_page'])->name('donate.page');
        Route::post('/donate', [DonatorController::class, 'donate'])->name('donate');
        
        Route::get('/order', [DonatorController::class, 'order_page'])->name('order.page');
        
        Route::get('/order/{order}', [DonatorController::class, 'order_update_page'])->name('order.update.page');
        Route::patch('/order/{order}', [DonatorController::class, 'order'])->name('order');
        
        Route::get('/{product}', [DonatorController::class, 'product_page'])->name('product.page');
        Route::post('/{product}', [DonatorController::class, 'update'])->name('update');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
