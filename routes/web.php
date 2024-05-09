<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\LikesController;
use App\Http\Controllers\MyStoreController;
use App\Http\Controllers\CoinController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

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

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile/address', [AddressController::class, 'address'])->name('address'); # customer.2 ✅
    Route::get('/profile/address/create', [AddressController::class, 'create_page'])->name('address.create'); # customer.3✅
    Route::post('/profile/address/create', [AddressController::class, 'create']);
    # Route::get('/profile/address/{id}', [AddressController::class, 'edit'])->name('address.edit');
    
    # Route::get('/profile/likes', [LikesController::class, 'likes'])->name('likes');
    

    Route::get('/mystore', [MyStoreController::class, 'mystore'])->name('mystore'); # seller.2
    Route::get('/mystore/create', [MyStoreController::class, 'create_page'])->name('mystore.create'); # seller.3
    Route::post('/mystore/create', [MyStoreController::class, 'create']);
    
    # Route::get('/mystore/edit', [MyStoreController::class, 'edit'])->name('mystore.edit');
    
    Route::get('/mystore/verification', [MyStoreController::class, 'verification_page'])->name('mystore.verification'); # seller.4
    Route::post('/mystore/verification', [MyStoreController::class, 'verification']);
    Route::get('/mystore/product', [MyStoreController::class, 'product'])->name('mystore.product'); # seller.5
    Route::get('/mystore/product/create', [MyStoreController::class, 'product_create_page'])->name('mystore.product.create'); # seller.6
    Route::post('/mystore/product/create', [MyStoreController::class, 'product_create']);
    Route::get('/mystore/order', [MyStoreController::class, 'order'])->name('mystore.order'); # seller.7
    Route::get('/mystore/order/{id}', [MyStoreController::class, 'order_edit_page'])->name('mystore.order.edit'); # seller.8
    Route::post('/mystore/order/{id}', [MyStoreController::class, 'order_edit']);

    Route::get('/coin', [CoinController::class, 'coin'])->name('coin'); # seller.9
    Route::get('/coin/history', [CoinController::class, 'history'])->name('coin.history'); # seller.10
    Route::get('/coin/history/{id}', [CoinController::class, 'history_detail'])->name('coin.history.detail'); # seller.11
    
    Route::get('/cart', [CartController::class, 'cart'])->name('cart'); # customer.7 ✅
    Route::post('/cart/add', [CartController::class, 'add']);
    Route::post('/cart/edit', [CartController::class, 'edit']);

    Route::post('/order', [OrderController::class, 'order'])->name('order'); # customer.8
    Route::post('/order/add', [OrderController::class, 'add']);
    Route::post('/order/payment', [OrderController::class, 'payment']);
    Route::get('/order/{id}', [OrderController::class, 'detail'])->name('order.detail'); # customer.11
    Route::get('/payment_gateway_demo', [OrderController::class, 'payment_gateway_demo'])->name('payment_gateway_demo'); # customer.9
    Route::get('/order/payment/callback', [OrderController::class, 'payment_callback'])->name('order.payment.callback'); # customer.10
    
});

Route::get('/test', [TestController::class, 'csrf']);

Route::get('', [HomeController::class, 'home'])->name('home'); # customer.1 seller.1 ✅
Route::get('/search', [SearchController::class, 'search'])->name('search'); # customer.5 ✅

# Route::get('/{store_name}', [StoreController::class, 'store'])->name('store');
# Route::get('/{store_name}/search', [StoreController::class, 'search'])->name('search');
# Route::get('/{store_name}/category', [StoreController::class, 'category'])->name('store.category');
# Route::get('/{store_name}/category/{category_name}', [StoreController::class, 'category_product'])->name('store.category.product');

Route::get('/{store_name}/{product_title}', [StoreController::class, 'product'])->name('store.product'); # customer.6

# Route::get('/{store_name}/{product_title}/review', [StoreController::class, 'product_review'])->name('store.product');