<?php

namespace App\Http\Controllers;

use App\Exceptions\WebException;
use App\Models\Coin;
use App\Models\CoinHistory;
use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\OrderPayment;
use App\Models\OrderPaymentStatus;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Store;
use App\Models\UserAddress;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Redirect;
use Route;

/**
 * Note kekurangan:
 * - Idempotency key
 * - Transaction DB
 */
class OrderController extends Controller
{
    public function order(Request $request) {
        try {
            $user = $request->user();
            $products = $request->get('products');

            $address = UserAddress::where([
                'user_id' => $user->id,
                'is_active' => true
            ])
            ->first();
            
            if (!$address) Redirect::to('/address');

            $mystore = Store::where('user_id', '=', $user->id)->first();

            $products_id = array_column($products, 'id');
            $check_products = Product::whereIn('id', $products_id);
            if ($mystore) $check_products->where('store_id', '<>', $mystore->id);
            $check_products = $check_products->get()->toArray();

            if (count($products) != count($check_products)) throw new WebException("There are products that were not found", 404);
            
            $products_store_id = array_unique(array_column($check_products, 'store_id'));
            $check_stores = Store::whereIn('id', $products_store_id)->get()->toArray();
            
            if (!count($check_stores)) throw new WebException("Stores are not found", 404);
            
            $data_products = [];
            foreach ($check_products as $check_product) {
                $product_key = array_search($check_product['id'], array_column($products, 'id'));
                if ($check_product['stock'] < $products[$product_key]['quantity']) throw new WebException('There are product stock that is less than quantity', 400);
                
                $store_key = array_search($check_product['store_id'], array_column($check_stores, 'id'));
                if (is_numeric($store_key) && !isset($data_products[$check_product['store_id']])) {
                    $data_products[$check_product['store_id']]['store'] = $check_stores[$store_key];
                    $data_products[$check_product['store_id']]['total']['products'] = 0;
                    $data_products[$check_product['store_id']]['total']['all'] = 0;
                }
                else if (!is_numeric($store_key)) throw new WebException('There are stores that were not found', 404);
                
                $data_products[$check_product['store_id']]['products'][] = array_merge(
                    $check_product,
                    [
                        'quantity' => $products[$product_key]['quantity'],
                    ]
                );

                $data_products[$check_product['store_id']]['total']['products'] += ($check_product['price'] * $products[$product_key]['quantity']);
                $data_products[$check_product['store_id']]['total']['all'] = $data_products[$check_product['store_id']]['total']['products'];
            }

            $total = [
                'products' => 0,
                'all' => 0
            ];
            foreach ($data_products as $products_per_store) {
                $total['products'] += $products_per_store['total']['products'];
            }

            $total['all'] = array_sum($total);

            return Inertia::render('Order/Index', [
                'canLogin' => Route::has('login'),
                'canRegister' => Route::has('register'),
                'data' => [
                    'address' => $address,
                    'products' => array_values($data_products),
                    'total' => $total
                ]
            ]);
        } catch (Exception $e) {
            throw new WebException($e->getMessage(), 500);
        }
    }

    public function order_list(Request $request) {
        try {
            $user = $request->user();

            $orders = Order::select(
                "orders.total",
                "orders.status",
                "stores.storename",
                "stores.name as store_name",
                "stores.province as store_province",
                "stores.latitude as store_latitude",
                "stores.longitude as store_longitude",
                "order_address.name as order_name",
                "order_address.phone as order_phone",
                "order_address.address as order_address",
                "order_address.subdistrict as order_subdistrict",
                "order_address.district as order_district",
                "order_address.city as order_city",
                "order_address.province as order_province",
                "order_address.latitude as order_latitude",
                "order_address.longitude as order_longitude",
                "order_address.gmaps_point as order_gmaps_point",
                "order_address.notes as order_notes",
            )
            ->join('order_address', 'order_address.order_id', '=', 'orders.id')
            ->join('store', 'store.id', '=', 'orders.store_id')
            ->where('orders.user_id', '=', $user->id)
            ->orderBy('orders.id', 'desc')
            ->get()
            ->toArray();

            return Inertia::render('Order/List/Index', [
                'canLogin' => Route::has('login'),
                'canRegister' => Route::has('register'),
                'data' => [
                    'order' => $orders
                ]
            ]);
        } catch (Exception $e) {
            throw new WebException($e->getMessage(), 500);
        }
    }

    public function add(Request $request) {
        try {
            $user = $request->user();

            $products = $request->get('products');
            $address = $request->get('address');
            $donate = $request->get('donate') ?? 0;

            $params = [];
            foreach ($products as $product) {
                $order = Order::create([
                    'user_id' => $user->id,
                    'store_id' => $product['store']['id'],
                    'total' => $product['total']['all'],
                    'status' => 'payment',
                ]);
                $params['orders'][] = $order->id;

                $create_address = [];
                $create_address['order_id'] = $order->id;
                $create_address['name'] = $address['name'];
                $create_address['phone'] = $address['phone'];
                $create_address['address'] = $address['address'];
                $create_address['subdistrict'] = $address['subdistrict'];
                $create_address['district'] = $address['district'];
                $create_address['city'] = $address['city'];
                $create_address['province'] = $address['province'];
                if (isset($address['latitude']) && !empty($address['latitude'])) $create_address['latitude'] = $address['latitude'];
                if (isset($address['longitude']) && !empty($address['longitude'])) $create_address['longitude'] = $address['longitude'];
                if (isset($address['gmaps_point']) && !empty($address['gmaps_point'])) $create_address['gmaps_point'] = $address['gmaps_point'];
                if (isset($address['notes']) && !empty($address['notes'])) $create_address['notes'] = $address['notes'];

                OrderAddress::create($create_address);

                $product_detail = [];
                foreach ($product['products'] as $i) {
                    $product_detail[] = [
                        'order_id' => $order->id,
                        'product_id' => $i['id'],
                        'product_title' => $i['title'],
                        // 'variant_id' => $i['variant_id'],
                        // 'variant_name' => $i['variant_name'],
                        'quantity' => $i['quantity'],
                        'price' => $i['price'],
                    ];
                }
                OrderProduct::insert($product_detail);

                $payment = OrderPayment::create([
                    'order_id' => $order->id,
                    'total' => $product['total']['all'],
                ]);

                OrderPaymentStatus::create([
                    'order_id' => $order->id,
                    'order_payment_id' => $payment->id,
                    'title' => 'Request Payment',
                ]);
            }

            $params = http_build_query($params);
            if ($donate > 0) $params .= "&donate=" . $donate;

            return Redirect::to('/order/payment?' . $params);
        } catch (Exception $e) {
            throw new WebException($e->getMessage(), 500);
        }
    }

    public function payment(Request $request) {
        try {
            $user = $request->user();
            $orders = $request->get('orders');
            $donate = $request->get('donate') ?? 0;

            $check_orders = Order::whereIn('id', $orders)->where('user_id', $user->id)->get()->toArray();
            if (count($check_orders) != count($orders)) throw new WebException('Orders not found', 404);

            $total = 0;
            foreach ($check_orders as $order) {
                $total += $order['total'];
            }

            if ($donate > 0) $total += $donate;

            $params = [ 'orders' => $orders, 'total' => $total ];
            $params = http_build_query($params);

            return Redirect::to('/payment_gateway_demo?' . $params);
        } catch (Exception $e) {
            throw new WebException($e->getMessage(), 500);
        }
    }

    public function payment_gateway_demo(Request $request) {
        try {
            $orders = $request->get('orders');
            $total = $request->get('total');

            return Inertia::render('Order/Payment/Demo', [
                'canLogin' => Route::has('login'),
                'canRegister' => Route::has('register'),
                'data' => [
                    'order' => $orders,
                    'total' => $total,
                ]
            ]);
        } catch (Exception $e) {
            throw new WebException($e->getMessage(), 500);
        }
    }
    
    public function payment_callback(Request $request) {
        try {
            $user = $request->user();
            $orders = $request->get('orders');

            $orders = Order::whereIn('order_id', $orders)->where('user_id', '=', $user->id)->get()->toArray();
            foreach ($orders as $order) {
                $payment = OrderPayment::where('order_id', '=', $order['id'])->first();
                OrderPaymentStatus::create([
                    'order_id' => $order['id'],
                    'order_payment_id' => $payment->id,
                    'title' => 'Payment successful',
                    'received' => true
                ]);
                $payment->received = true;
                $payment->save();

                Order::where('id', '=', $order['id'])->update(['status' => 'waiting to be picked up']);
            }

            return Inertia::render('Order/Payment/Callback', [
                'canLogin' => Route::has('login'),
                'canRegister' => Route::has('register'),
                'data' => [
                    'order' => $orders
                ]
            ]);
        } catch (Exception $e) {
            throw new WebException($e->getMessage(), 500);
        }
    }

    public function detail(Request $request, int $id) {
        try {
            $user = $request->user();

            $order = Order::where('id', '=', $id)->where('user_id', '=', $user->id)->first();
            if (!$order) throw new WebException('Order not found', 404);
            
            $store = Store::where('store_id', '=', $order->store_id)->first();
            if (!$store) throw new WebException('Store not found', 404);

            $address = OrderAddress::where('order_id', '=', $order->id)->first();
            
            $products = OrderProduct::where('order_id', '=', $order->id)->get()->toArray();

            $payment = OrderPayment::where('order_id', '=', $order->id)->first();

            return Inertia::render('Order/Detail', [
                'canLogin' => Route::has('login'),
                'canRegister' => Route::has('register'),
                'data' => [
                    'order' => $order,
                    'store' => $store,
                    'address' => $address,
                    'products' => $products,
                    'payment' => $payment,
                ]
            ]);
        } catch (Exception $e) {
            throw new WebException($e->getMessage(), 500);
        }
    }

    public function detail_edit(Request $request, int $id) {
        try {
            $user = $request->user();

            $status = $request->get('status');

            $order = Order::where('id', '=', $id)->where('user_id', '=', $user->id)->first();
            if (!$order) throw new WebException('Order not found', 404);
            
            $store = Store::where('store_id', '=', $order->store_id)->first();
            if (!$store) throw new WebException('Store not found', 404);

            $order->status = $status;
            $order->save();

            if ($status == 'completed') {
                $coin = Coin::where('store_id', '=', $store->id)->first();
                if (!$coin) $coin = Coin::create([
                    'user_id' => $store->user_id,
                    'balance' => $order->total
                ]);
                else {
                    $coin->balance = $coin->balance + $order->total;
                    $coin->save();

                    CoinHistory::create([
                        'user_id' => $store->user_id,
                        'order_id' => $order->id,
                        'title' => 'Products sold',
                        'debit' => true,
                        'status' => 'paid',
                        'from' => $user->username,
                        'total' => $order->total,
                    ]);
                }
            }

            return Redirect::to('/order');
        } catch (Exception $e) {
            throw new WebException($e->getMessage(), 500);
        }
    }
}
