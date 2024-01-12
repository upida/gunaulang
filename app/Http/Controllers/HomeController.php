<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductMedia;
use App\Models\Store;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Route;

class HomeController extends Controller
{
    public function page(Request $request)
    {
        $products = Product::orderByDesc('updated_at')->get()->toArray();
        foreach($products as $key => $product) {
            $media = ProductMedia::where('product_id', $product['id'])->first();
            $products[$key]['image'] = asset("storage/$media->url");
        }

        return Inertia::render('Home', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'products' => $products
        ]);
    }

    public function product_page(Request $request, Product $product)
    {
        $product = $product->toArray();
        if($product['expired_at']) $product['expired_at'] = date('Y-m-d', strtotime($product['expired_at']));
        if($product['updated_at']) $product['updated_at'] = date('Y-m-d', strtotime($product['updated_at']));
        $product['danger'] = (bool) $product['danger'];
        $product['food'] = (bool) $product['food'];
        $product['status'] = (bool) $product['status'];
        $media = ProductMedia::where('product_id', $product['id'])->get();
        $product['images'] = [];
        foreach ($media as $image) {
            $product['images'][] = asset("storage/$image[url]");
        }

        $store = Store::find($product['store_id']);

        return Inertia::render('Product', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'product' => $product,
            'store' => $store
        ]);
    }

    public function category_page(Request $request)
    {
        return Inertia::render('Category', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register')
        ]);
    }

    public function search_page(Request $request)
    {
        $q = $request->get('q') ?? '';
        $products = [];

        if ($q) {
            $products = Product::where('title', 'like', "%$q%")->orWhere('description', 'like', "%$q%")->get()->toArray();
            foreach($products as $key => $product) {
                $media = ProductMedia::where('product_id', $product['id'])->first();
                $products[$key]['image'] = asset("storage/$media->url");
            }
        }

        return Inertia::render('Search', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'q' => $q,
            'searchResults' => $products
        ]);
    }
}
