<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Exceptions\WebException;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Product;
use App\Models\Store;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Route;

class CartController extends Controller
{
    public function cart(Request $request) {
        try {
            $user = $request->user();

            $data = Cart::select(
                'carts.id as id',
                'stores.id as store_id',
                'stores.name as storename',
                'stores.name as store_name',
                'cart_products.quantity as quantity',
                'products.id as product_id',
                'products.title as title',
                'products.stock as stock',
                'products.price as price'
            )
            ->join('stores', 'carts.store_id', '=', 'stores.id')
            ->join('cart_products', 'carts.id', '=', 'cart_products.cart_id')
            ->join('products', 'cart_products.product_id', '=', 'products.id')
            ->where('carts.user_id', $user->id)
            ->orderBy('carts.id', 'desc')
            ->get()
            ->toArray();

            $carts = [];
            foreach($data as $cart) {
                if (!isset($carts[$cart['storename']])) {
                    $carts[$cart['storename']] = [
                        'cart' => [
                            'id' => $cart['id']
                        ],
                        'store' => [
                            'id' => $cart['store_id'],
                            'storename' => $cart['storename'],
                            'store_name' => $cart['store_name'],
                        ],
                        'product' => []
                    ];
                }

                $carts[$cart['storename']]['product'][] = [
                    'id' => $cart['product_id'],
                    'title' => $cart['title'],
                    'stock' => $cart['stock'],
                    'price' => $cart['price'],
                    'quantity' => $cart['quantity'],
                ];
            }

            return Inertia::render('Cart/Index', [
                'canLogin' => Route::has('login'),
                'canRegister' => Route::has('register'),
                'data' => [
                    'cart' => $carts
                ]
            ]);
        } catch (Exception $e) {
            throw new WebException($e->getMessage(), 500);
        }
    }

    public function add(Request $request) {
        try {
            $user = $request->user();

            $id = $request->get('id');
            $quantity = $request->get('quantity');

            $mystore = Store::where('user_id', '=', $user->id)->first();
            
            $product = Product::where('id', '=', $id)
            ->first();

            if (!$product) throw new ApiException('Product not found', 404);
            else if ($mystore && $product->store_id == $mystore->id) throw new ApiException('You cannot order your own product', 400);
            else if ($product->stock < $quantity) throw new ApiException('Product stock is less than quantity', 400);

            $cart = Cart::where('user_id', '=', $user->id)->where('store_id', '=', $product->store_id)->first();
            if (!$cart) $cart = Cart::create([ 'user_id' => $user->id, 'store_id' => $product->store_id ]);

            $cart_product = CartProduct::where('cart_id', '=', $cart->id)->where('product_id', '=', $id)->first();
            if (!$cart_product) $cart_product = CartProduct::create([ 'cart_id' => $cart->id, 'product_id' => $id, 'quantity' => $quantity ]);
            else {
                $quantity = $cart_product->quantity + $quantity;
                $cart_product->quantity = $quantity;
                $cart_product->save();
            }

            return response()->json([[
                'data' => [
                    'product' => $product,
                    'quantity' => $quantity
                ]
            ]]);
        } catch (Exception $e) {
            throw new ApiException($e->getMessage(), 500);
        }
    }
    
    public function edit(Request $request) {
        try {
            $user = $request->user();

            $id = $request->get('id');
            $quantity = $request->get('quantity');

            $cart_product = CartProduct::where('user_id', '=', $user->id)
            ->where('product_id', '=', $id)
            ->first();
            if (!$cart_product) throw new ApiException('Product not found in your cart', 404);

            $cart = Cart::where('id', $cart_product->cart_id)->where('user_id', '=', $user->id)->first();
            if (!$cart) {
                $cart_product->delete();
                throw new ApiException('Cart not found', 404);
            }

            $product = Product::where('id', '=', $cart_product->product_id)->first();
            if (!$product) {
                $cart->delete();
                throw new ApiException('Product not found', 404);
            }

            if ($product->stock < $quantity) throw new ApiException('Product stock is less than quantity', 400);

            if ($quantity > 0) {
                $cart_product->quantity = $quantity;
                $cart_product->save();
            } else {
                $cart_product->delete();
                $cart_product = CartProduct::where('cart_id', '=', $cart->id)->first();
                if (!$cart_product) $cart->delete();
            }

            return response()->json([
                'data' => [
                    'product' => $product,
                    'quantity' => $quantity
                ]
            ]);
        } catch (Exception $e) {
            throw new ApiException($e->getMessage(), 500);
        }
    }
}
