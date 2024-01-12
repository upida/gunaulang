<?php

namespace App\Http\Controllers;

use App\Http\Requests\DonatorOrderUpdateRequest;
use App\Http\Requests\StoreCreateRequest;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductMedia;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Route;

class DonatorController extends Controller
{
    public function page(Request $request)
    {
        $store = Store::where('user_id', $request->user()->id)->first();
        $products = [];
        if ($store) {
            $products = Product::where('store_id', $store->id)->get()->toArray();
            foreach($products as $key => $product) {
                $media = ProductMedia::where('product_id', $product['id'])->first();
                $products[$key]['image'] = asset("storage/$media->url");
            }
            $store = $store->toArray();
        } else {
            return redirect(route('donator.store.page'));
        }
        return Inertia::render('Donator/Index', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'store' => $store,
            'products' => $products,
        ]);
    }

    public function store_page(Request $request)
    {
        $store = Store::where('user_id', $request->user()->id)->first();
        if ($store) $store = $store->toArray();

        return Inertia::render('Donator/Store', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'store' => $store,
        ]);
    }

    public function store(StoreCreateRequest $request)
    {
        Store::updateOrInsert(
            ['user_id' => $request->user()->id],
            $request->all()
        );
        
        return redirect(route('donator.store.page'));
    }

    public function donate_page(Request $request)
    {
        $store = Store::where('user_id', $request->user()->id)->first();
        if (!$store) return redirect(route('donator.store.page'));

        return Inertia::render('Donator/Donate', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'store' => $store,
        ]);
    }

    public function donate(Request $request)
    {
        $store = Store::where('user_id', $request->user()->id)->first();
        if (!$store) return redirect(route('donator.store.page'));

        $photos = [];
        foreach($request['images'] as $image) {
            if ($path = Storage::disk('public')->putFile('media/' . $request->user()->id, $image['file'])) {
                $photos[] = $path;
            }
        }

        $data = $request->all();
        $product_id = Product::insertGetId([
            'store_id' => $store->id,
            'title' => $data['title'] ?? null,
            'description' => $data['description'] ?? null,
            'danger' => $data['danger'] ?? null,
            'stock' => $data['stock'] ?? null,
            'condition' => $data['condition'] ?? null,
            'food' => $data['food'] ?? null,
            'expired_at' => $data['expired_at'] ?? null,
            'status' => $data['status'] ?? null,
        ]);

        $insertPhotos = [];
        foreach($photos as $photo) {
            $insertPhotos[] = [
                'product_id' => $product_id,
                'url' => $photo
            ];
        }

        ProductMedia::insert($insertPhotos);

        return redirect(route('donator.page'));
    }

    public function product_page(Request $request, Product $product)
    {
        $store = Store::where('user_id', $request->user()->id)->first();
        if ($store->id != $product->store_id) {
            return redirect(route('donator.store.page'));
        }
        
        $images = ProductMedia::where('product_id', $product->id)->get()->toArray();

        $product = $product->toArray();
        $product['images'] = [];

        $product['danger'] = (int) $product['danger'];
        
        foreach ($images as $image) {
            $product['images'][] = asset("storage/$image[url]");
        }
        return Inertia::render('Donator/Product', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'product' => $product,
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $store = Store::where('user_id', $request->user()->id)->first();
        if (!$store) return redirect(route('donator.store.page'));

        ProductMedia::where('product_id', $product->id)->delete();

        $photos = [];
        foreach($request['images'] as $image) {
            if ($path = Storage::disk('public')->putFile('media/' . $request->user()->id, $image['file'])) {
                $photos[] = $path;
            }
        }

        $data = $request->all();

        if (isset($data['title']) && !empty($data['title'])) {
            $product->title = $data['title'];
        }
        if (isset($data['description']) && !empty($data['description'])) {
            $product->description = $data['description'];
        }
        if (isset($data['danger'])) {
            $product->danger = $data['danger'];
        }
        if (isset($data['stock']) && !empty($data['stock'])) {
            $product->stock = $data['stock'];
        }
        if (isset($data['condition']) && !empty($data['condition'])) {
            $product->condition = $data['condition'];
        }
        if (isset($data['food'])) {
            $product->food = $data['food'];
        }
        if (isset($data['expired_at']) && !empty($data['expired_at'])) {
            $product->expired_at = date('Y-m-d', strtotime($data['expired_at']));
        }
        if (isset($data['status'])) {
            $product->status = $data['status'];
        }

        $product->save();

        $insertPhotos = [];
        foreach($photos as $photo) {
            $insertPhotos[] = [
                'product_id' => $product->id,
                'url' => $photo
            ];
        }

        ProductMedia::insert($insertPhotos);

        return redirect(route('donator.product.page', [
            "product" => $product['id']
        ]));
    }

    public function order_page(Request $request)
    {
        $store = Store::where('user_id', $request->user()->id)->first();
        if (!$store) return redirect(route('donator.store.page'));

        $order = Order::where('store_id', $store->id)->get()->toArray();

        return Inertia::render('Donator/Order', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'store' => $store,
            'order' => $order,
        ]);
    }

    public function order_update_page(Request $request, $order_id)
    {
        $store = Store::where('user_id', $request->user()->id)->first();
        if (!$store) return redirect(route('donator.store.page'));

        $order = Order::where('id', $order_id)->where('store_id', $store->id)->first();

        return Inertia::render('Donator/Order.Update', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'store' => $store,
            'order' => $order,
        ]);
    }

    public function order(DonatorOrderUpdateRequest $request, $order)
    {
        Order::update(
            ['store_id' => $request->get('store')->id, 'order_id' => $order->id],
            $request->all()
        );
        
        return redirect(route('donator.order.update.page'));
    }
    
}
