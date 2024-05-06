<?php

namespace App\Http\Controllers;

use App\Exceptions\WebException;
use App\Models\Product;
use App\Models\ProductMedia;
use App\Models\Review;
use App\Models\ReviewMedia;
use App\Models\Store;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Redirect;
use Route;

class StoreController extends Controller
{
    public function store(Request $request) {
        try {
            // $user = $request->user();

            // $store = Store::where('user_id', $user->id)
            // ->first();

            // if (!$store) return Redirect::to('/')

            // $products = Product::where('store_id', $store->id)
            // ->orderBy('created_at', 'desc')
            // ->limit(100);

            return Inertia::render('Store/Index', [
                'canLogin' => Route::has('login'),
                'canRegister' => Route::has('register'),
                // 'store' => $store,
                // 'product' => $products
            ]);
        } catch (Exception $e) {
            throw new WebException($e->getMessage(), 500);
        }
    }

    public function search(Request $request) {
        try {
            // $user = $request->user();

            return Inertia::render('Store/Search/Index', [
                'canLogin' => Route::has('login'),
                'canRegister' => Route::has('register'),
                // 'store' => $store,
                // 'product' => $products
            ]);
        } catch (Exception $e) {
            throw new WebException($e->getMessage(), 500);
        }
    }

    public function category(Request $request) {
        try {
            return Inertia::render('Home', [
                'canLogin' => Route::has('login'),
                'canRegister' => Route::has('register'),
            ]);
        } catch (Exception $e) {
            throw new WebException($e->getMessage(), 500);
        }
    }

    public function category_product(Request $request) {
        try {
            return Inertia::render('Home', [
                'canLogin' => Route::has('login'),
                'canRegister' => Route::has('register'),
            ]);
        } catch (Exception $e) {
            throw new WebException($e->getMessage(), 500);
        }
    }

    public function product(Request $request, string $store_name, string $product_title) {
        try {
            $user = $request->user();

            $store = Store::where('storename', '=', $store_name)->first();

            $product = Product::where('store_id', '=', $store->id)
            ->where('title', '=', $product_title)
            ->first();

            $product_media = ProductMedia::where('product_id', '=', $product->id)
            ->get()
            ->toArray();

            $reviews = Review::where('product_id', '=', $product->id)
            ->limit(3)
            ->get()
            ->toArray();

            foreach($reviews as $review_key => $review) {
                $reviews[$review_key]['media'] = ReviewMedia::where('review_id', '=', $review['id'])->get()->toArray();
            }

            return Inertia::render('Product/Index', [
                'canLogin' => Route::has('login'),
                'canRegister' => Route::has('register'),
                'data' => [
                    'store' => $store,
                    'product' => $product,
                    'product_media' => $product_media,
                    'review' => $reviews,
                ]
            ]);
        } catch (Exception $e) {
            throw new WebException($e->getMessage(), 500);
        }
    }

    public function product_review(Request $request) {
        try {
            return Inertia::render('Home', [
                'canLogin' => Route::has('login'),
                'canRegister' => Route::has('register'),
            ]);
        } catch (Exception $e) {
            throw new WebException($e->getMessage(), 500);
        }
    }
}
