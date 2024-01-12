<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderRecipient;
use App\Models\OrderShipment;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function list_page(Request $request)
    {
        $orders = Order::where('user_id', $request->user()->id)->latest()->get()->toArray();

        foreach ($orders as $key => $order) {
            $products = OrderProduct::where('order_id', $order['id'])->get()->toArray();
            foreach ($products as $product_key => $product) {
                $detail_product = Product::where('id', $product['product_id'])->first()->toArray();
                $products[$product_key] = array_merge($detail_product, $product);
            }
            $orders[$key]['products'] = $products;
            $orders[$key]['store'] = Store::where('store_id', $order['store_id'])->first();
            $orders[$key]['shipment'] = OrderShipment::where('order_id', $order['store_id'])->first();
        }

        return Inertia::render('Order/List', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'orders' => $orders
        ]);
    }

    public function checkout_page(Request $request)
    {
        $cart_products = $request->get('cart_products');

        $cart_products = CartProduct::whereIn('id', $cart_products)->get()->toArray();
        $carts = $this->groupByStore($cart_products);

        return Inertia::render('Order/Checkout', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'carts' => $carts
        ]);
    }

    public function create(Request $request)
    {
        $recipient = $request->get('recipient');
        $carts = $request->get('carts');
        $shippings = $request->get('shippings');

        foreach ($carts as $cart) {
            $order = Order::create([
                'user_id' => $request->user()->id,
                'store_id' => $cart['store_id'],
                'total' => 0,
                'status' => 'Pending',
            ]);

            OrderRecipient::create([
                'order_id' => $order->id,
                'name' => $recipient['name'],
                'phone' => $recipient['phone'],
                'address' => $recipient['address'],
                'subdistrict' => $recipient['subdistrict'],
                'district' => $recipient['district'],
                'province' => $recipient['province'],
            ]);

            $shipping = $shippings[$cart['store_id']];
            OrderShipment::create([
                'order_id' => $order->id,
                'shipment_method' => $shipping['method'],
                'shipment_total' => 0,
            ]);

            foreach ($cart['products'] as $product) {
                OrderProduct::create([
                    'order_id' => $order->id,
                    'product_id' => $product['id'],
                    'quantity' => $product['quantity'],
                    'note' => '',
                ]);
            }
        }

        return redirect(route('order.list.page'));
    }
    
    private function groupByStore($cart_products)
    {
        $new_cart_products = [];
        $new_products = [];

        foreach ($cart_products as $cart_product) {
            $new_products[] = array_merge(Product::find($cart_product['product_id'])->toArray(), $cart_product);  
        }

        foreach ($new_products as $product) {
            if (!isset($new_cart_products[$product['store_id']])) 
            $new_cart_products[$product['store_id']] = [
                'store' => $this->getStore($product['store_id']),
                'products' => [],
            ];

            $new_cart_products[$product['store_id']]['products'][] = $product;
        }
        
        return array_values($new_cart_products);
    }

    private function getStore($store_id)
    {
        static $stores = [];

        if (!isset($stores[$store_id])) {
            $store = Store::find($store_id);
            $stores[$store_id] = $store;
        }

        return $stores[$store_id];
    }
}
