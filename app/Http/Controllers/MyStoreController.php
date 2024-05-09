<?php

namespace App\Http\Controllers;

use App\Exceptions\WebException;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductMedia;
use App\Models\Store;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Redirect;
use Route;
use Storage;
use Illuminate\Validation\Rules\File;

class MyStoreController extends Controller
{
    public function mystore(Request $request) {
        try {
            $user = $request->user();

            $store = Store::where('user_id', $user->id)
            ->first();

            if (!$store) return Redirect::to('/mystore/create');

            // $products = Product::where('store_id', $store->id)
            // ->orderBy('created_at', 'desc')
            // ->limit(100)
            // ->get()
            // ->toArray();

            return Inertia::render('Mystore/Index', [
                'canLogin' => Route::has('login'),
                'canRegister' => Route::has('register'),
                'data' => [
                    'store' => $store,
                    // 'product' => $products,
                ]
            ]);
        } catch (Exception $e) {
            throw new WebException($e->getMessage(), 500);
        }
    }

    public function create_page(Request $request) {
        try {
            $user = $request->user();

            $store = Store::where('user_id', $user->id)
            ->first();

            if ($store) return Redirect::to('/mystore');

            return Inertia::render('Mystore/Create', [
                'canLogin' => Route::has('login'),
                'canRegister' => Route::has('register'),
            ]);
        } catch (Exception $e) {
            throw new WebException($e->getMessage(), 500);
        }
    }

    public function create(Request $request) {
        try {
            $user = $request->user();

            $store = Store::where('user_id', $user->id)
            ->first();

            if ($store) return Redirect::to('/mystore');

            $request->validate([
                'storename' => 'required|string|regex:/^[a-z0-9_-]{3,20}$/|unique:'.Store::class,
                'name' => 'required|string|max:30|unique:'.Store::class,
                'description' => 'nullable|string',
                'logo' => 'nullable',
                'cover' => 'nullable',
                'phone' => 'required|string|regex:/^[a-z0-9_-]{3,15}$/',
                'address' => 'required|string|max:100',
                'subdistrict' => 'required|string|max:50',
                'district' => 'required|string|max:50',
                'city' => 'required|string|max:20',
                'province' => 'required|string|max:20',
                'latitude' => 'nullable|string|max:20',
                'longitude' => 'nullable|string|max:20',
                'gmaps_point' => 'nullable|string|max:20',
                'notes' => 'nullable|string|max:50',
            ],[
                'storename.regex' => 'The storename field format only allows alphabets, numbers, and underscores (_). The length is 3 to 20 characters.',
                'phone.regex' => 'The phone field format starts with 0. The length is 9 to 13 characters.'
            ]);

            Store::create([
                'user_id' => $user->id,
                'storename' => $request->get('storename'),
                'name' => $request->get('name'),
                'description' => $request->get('description'),
                'logo' => $request->get('logo'),
                'cover' => $request->get('cover'),
                'phone' => $request->get('phone'),
                'address' => $request->get('address'),
                'subdistrict' => $request->get('subdistrict'),
                'district' => $request->get('district'),
                'city' => $request->get('city'),
                'province' => $request->get('province'),
                'latitude' => $request->get('latitude'),
                'longitude' => $request->get('longitude'),
                'gmaps_point' => $request->get('gmaps_point'),
                'notes' => $request->get('notes'),
            ]);

            return Redirect::to('/mystore');
        } catch (Exception $e) {
            throw new WebException($e->getMessage(), 500);
        }
    }

    public function edit(Request $request) {
        try {
            return Inertia::render('Home', [
                'canLogin' => Route::has('login'),
                'canRegister' => Route::has('register'),
            ]);
        } catch (Exception $e) {
            throw new WebException($e->getMessage(), 500);
        }
    }

    public function verification_page(Request $request) {
        try {
            return Inertia::render('Mystore/Verification', [
                'canLogin' => Route::has('login'),
                'canRegister' => Route::has('register'),
            ]);
        } catch (Exception $e) {
            throw new WebException($e->getMessage(), 500);
        }
    }

    public function verification(Request $request) {
        try {
            return Redirect::to('/mystore/verification');
        } catch (Exception $e) {
            throw new WebException($e->getMessage(), 500);
        }
    }

    public function product(Request $request) {
        try {
            $user = $request->user();

            $store = Store::where('user_id', $user->id)
            ->first();

            if (!$store) return Redirect::to('/mystore/create');

            $product = Product::where('store_id', $store->id)
            ->orderBy('created_at', 'desc')
            ->orderBy('is_active', 'desc')
            ->get()
            ->toArray();

            return Inertia::render('Mystore/Product/Index', [
                'canLogin' => Route::has('login'),
                'canRegister' => Route::has('register'),
                'data' => [
                    'store' => $store,
                    'product' => $product,
                ]
            ]);
        } catch (Exception $e) {
            throw new WebException($e->getMessage(), 500);
        }
    }

    public function product_create_page(Request $request) {
        try {
            $user = $request->user();

            $store = Store::where('user_id', $user->id)
            ->first();

            if (!$store) return Redirect::to('/mystore/create');

            return Inertia::render('Mystore/Product/Create', [
                'canLogin' => Route::has('login'),
                'canRegister' => Route::has('register'),
            ]);
        } catch (Exception $e) {
            throw new WebException($e->getMessage(), 500);
        }
    }

    public function product_create(Request $request) {
        try {
            $user = $request->user();

            $store = Store::where('user_id', $user->id)
            ->first();

            if (!$store) return Redirect::to('/mystore/create');

            $request->validate([
                'title' => 'required|string|max:20',
                'description' => 'nullable|string',
                'stock' => 'required|integer|min:1',
                'is_new' => 'nullable|boolean',
                'is_food' => 'nullable|boolean',
                'price' => 'required|decimal:0',
                'expired_at' => 'nullable|date|after:today',
                'media.*.file' => [
                    'required',
                    File::types([
                        'jpg',
                        'jpeg',
                        'png',
                        'bmp',
                        'gif',
                        'svg',
                        'webp',
                        'flv',
                        'mp4',
                        'mov',
                        'avi',
                        'wmv'
                    ])
                    ->max(12 * 1024)
                ],
            ],[
                'phone.regex' => 'The phone field format starts with 0. The length is 9 to 13 characters.'
            ]);

            $title = $request->get('title');
            $description = $request->get('description');
            $stock = $request->get('stock');
            $is_new = $request->get('is_new');
            $is_food = $request->get('is_food');
            $price = $request->get('price');
            $expired_at = $request->get('expired_at');

            $add_products = [];
            $add_products['store_id'] = $store->id;
            $add_products['title'] = $title;
            if ($description) $add_products['description'] = $description;
            $add_products['stock'] = $stock;
            if ($is_new) $add_products['is_new'] = $is_new;
            if ($is_food) $add_products['is_food'] = $is_food;
            $add_products['price'] = $price;
            if ($expired_at) $add_products['expired_at'] = date('Y-m-d', strtotime($expired_at));

            $product = Product::create($add_products);

            $all_media = [];
            foreach($request->file('media') as $media) {
                // upload media
                $path = Storage::disk('public')->putFile('Media/' . $user->id, $media['file']);

                $all_media[] = [
                    'product_id' => $product->id,
                    'path' => $path
                ];
            }

            ProductMedia::insert($all_media);

            return Redirect::to('/mystore/product');
        } catch (Exception $e) {
            throw new WebException($e->getMessage(), 500);
        }
    }
    
    public function order(Request $request) {
        try {
            $user = $request->user();

            $store = Store::where('user_id', $user->id)
            ->first();

            if (!$store) return Redirect::to('/mystore/create');

            $orders = Order::select([
                'orders.id',
                'orders.total',
                'orders.status',
                'users.username',
            ])
            ->selectRaw("
                DATE_FORMAT(orders.created_at, '%Y-%m-%d') as created
            ")
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->where('orders.store_id', '=', $store->id)
            ->orderBy('orders.id', 'desc')
            ->get()->toArray();

            return Inertia::render('Mystore/Order/Index', [
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

    public function order_edit_page(Request $request, int $id) {
        try {
            $user = $request->user();

            $store = Store::where('user_id', $user->id)
            ->first();

            if (!$store) return Redirect::to('/mystore/create');

            $order = Order::where('store_id', '=', $store->id)
            ->where('id', '=', $id)
            ->first();

            if (!$order) throw new WebException('Order not found', 404);

            return Inertia::render('Mystore/Order/Edit', [
                'canLogin' => Route::has('login'),
                'canRegister' => Route::has('register'),
                'data' => [
                    'order' => $order
                ]
            ]);
        } catch (Exception $e) {
            throw new WebException($e->getMessage(), 500);
        }
    }

    public function order_edit(Request $request, int $id) {
        try {
            $user = $request->user();

            $status = $request->get('status');

            $store = Store::where('user_id', $user->id)
            ->first();

            if (!$store) return Redirect::to('/mystore/create');

            $order = Order::where('store_id', '=', $store->id)
            ->where('id', '=', $id)
            ->first();

            if (!$order) throw new WebException('Order not found', 404);

            $order->status = $status;
            $order->save();

            return Redirect::to('/mystore/order');
        } catch (Exception $e) {
            throw new WebException($e->getMessage(), 500);
        }
    }
}
