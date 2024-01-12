<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Route;

class CartController extends Controller
{
    public function page(Request $request)
    {
        $carts = Cart::where('user_id', $request->user()->id)->latest()->get()->toArray();

        foreach ($carts as $key => $cart) {
            $carts[$key]['store'] = $this->get_store($cart['store_id']);
            $carts[$key]['products'] = $this->get_product($cart['id']);
        }

        return Inertia::render('Cart', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'carts' => $carts
        ]);
    }

    public function edit(Request $request, Product $product)
    {
        $cart = Cart::firstOrCreate([
            'user_id' => $request->user()->id, 'store_id' => $product->store_id
        ]);
        
        CartProduct::updateOrInsert(
            [ 'cart_id' => $cart->id, 'product_id' => $product->id ],
            [ 'quantity' => $request->get('quantity'), 'note' => '' ]
        );

        return redirect(route('product', [
            'product' => $product->id
        ]));
    }
    
    private function get_store($id) {
        static $stores;
        
        if (!isset($stores[$id])) {
            $store = Store::find($id);
            $stores[$store->id] = $store;
        }

        return $stores[$id];
    }

    private function get_product($cart_id) {
        $cart_products = CartProduct::where('cart_id', $cart_id)->get()->toArray();

        foreach ($cart_products as $key => $cart_product) {
            $cart_products[$key]['product'] = Product::find($cart_product['product_id']);
        }

        return $cart_products;
    }
}
