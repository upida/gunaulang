<?php

namespace App\Http\Controllers;

use App\Exceptions\WebException;
use App\Models\Product;
use App\Models\ProductMedia;
use App\Models\UserAddress;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Redirect;
use Route;

class HomeController extends Controller
{
    public function home(Request $request) {
        try {
            $user = $request->user();

            $data = [
                'address' => [],
                'product' => [
                    'free_food' => [],
                    'cheap_food' => [],
                    'food_waste' => [],
                    'processed_waste' => [],
                ]
            ];

            if ($user) {
                $data['address'] = UserAddress::where([
                    'user_id' => $user->id,
                    'is_active' => true
                ])
                ->first();
            }

            if (!$data['address']) return Redirect::to('/profile/address');

            $today = date('Y-m-d');

            // product.free_food
            $data['product']['free_food'] = Product::select(
                "products.id",
                "products.store_id",
                "products.title",
                "products.description",
                "products.stock",
                "products.is_new",
                "products.is_food",
                "products.is_active",
                "products.price",
                "products.expired_at",
                "products.likes",
                "stores.storename",
                "stores.name",
                "stores.province",
                "stores.latitude",
                "stores.longitude"
            );

            if (!empty($data['address']['latitude']) && !empty($data['address']['longitude'])) {
                $data['product']['free_food'] = $data['product']['free_food']
                ->selectRaw('
                    (
                        6371 * 1000 * acos(
                            cos(radians(?))
                            * cos(radians(stores.latitude)) 
                            * cos(radians(stores.longitude) - radians(?)) 
                            + sin(radians(?)) * sin(radians(stores.latitude))
                        )
                    ) AS distance', 
                    [
                        $data['address']['latitude'],
                        $data['address']['longitude'],
                        $data['address']['latitude']
                    ]
                );
            } 
            
            $data['product']['free_food'] = $data['product']['free_food']
            ->join('stores', 'products.store_id', '=', 'stores.id');

            if (
                empty($data['address']['latitude']) &&
                empty($data['address']['longitude']) &&
                !empty($data['address']['province'])
            ) {
                $data['product']['free_food'] = $data['product']['free_food']
                ->where('stores.province', '=', $data['address']['province']);
            }

            $data['product']['free_food'] = $data['product']['free_food']->where([
                ['products.stock', '>', 0],
                ['products.is_new', '=', true],
                ['products.is_food', '=', true],
                ['products.price', '=', 0],
                ['products.expired_at', '>=', $today],
            ]);
            
            if (!empty($data['address']['latitude']) && !empty($data['address']['longitude'])) {
                $data['product']['free_food'] = $data['product']['free_food']->orderBy('distance');
            }

            $data['product']['free_food'] = $data['product']['free_food']->orderBy('products.created_at', 'desc');
            $data['product']['free_food'] = $data['product']['free_food']->limit(10);
            $data['product']['free_food'] = $data['product']['free_food']->get()->toArray();

            $free_food_id = array_column($data['product']['free_food'], 'id');
            $media = ProductMedia::whereIn('product_id', $free_food_id)->get()->toArray();

            $data['product']['free_food'] = array_reduce($data['product']['free_food'], function (array $accumulator, array $element) {
                $accumulator[$element['id']] = $element;

                return $accumulator;
            }, []);

            foreach ($media as $m) {
                if (!isset($data['product']['free_food'][$m['product_id']]['media'])) $data['product']['free_food'][$m['product_id']]['media'] = [];
                $data['product']['free_food'][$m['product_id']]['media'][] = $m;
            }
            
            $data['product']['free_food'] = array_values($data['product']['free_food']);

            // product.cheap_food
            $data['product']['cheap_food'] = Product::select(
                "products.id",
                "products.store_id",
                "products.title",
                "products.description",
                "products.stock",
                "products.is_new",
                "products.is_food",
                "products.is_active",
                "products.price",
                "products.expired_at",
                "products.likes",
                "stores.storename",
                "stores.name",
                "stores.province",
                "stores.latitude",
                "stores.longitude"
            );

            if (!empty($data['address']['latitude']) && !empty($data['address']['longitude'])) {
                $data['product']['cheap_food'] = $data['product']['cheap_food']
                ->selectRaw('
                    (
                        6371 * 1000 * acos(
                            cos(radians(?))
                            * cos(radians(stores.latitude)) 
                            * cos(radians(stores.longitude) - radians(?)) 
                            + sin(radians(?)) * sin(radians(stores.latitude))
                        )
                    ) AS distance', 
                    [
                        $data['address']['latitude'],
                        $data['address']['longitude'],
                        $data['address']['latitude']
                    ]
                );
            } 
            
            $data['product']['cheap_food'] = $data['product']['cheap_food']
            ->join('stores', 'products.store_id', '=', 'stores.id');

            if (
                empty($data['address']['latitude']) &&
                empty($data['address']['longitude']) &&
                !empty($data['address']['province'])
            ) {
                $data['product']['cheap_food'] = $data['product']['cheap_food']
                ->where('stores.province', '=', $data['address']['province']);
            }

            $data['product']['cheap_food'] = $data['product']['cheap_food']->where([
                ['products.stock', '>', 0],
                ['products.is_new', '=', true],
                ['products.is_food', '=', true],
                ['products.price', '>', 0],
                ['products.expired_at', '>=', $today],
            ]);
            
            if (!empty($data['address']['latitude']) && !empty($data['address']['longitude'])) {
                $data['product']['cheap_food'] = $data['product']['cheap_food']->orderBy('distance');
            }

            $data['product']['cheap_food'] = $data['product']['cheap_food']->orderBy('products.created_at', 'desc');
            $data['product']['cheap_food'] = $data['product']['cheap_food']->limit(10);
            $data['product']['cheap_food'] = $data['product']['cheap_food']->get()->toArray();

            $cheap_food_id = array_column($data['product']['cheap_food'], 'id');
            $media = ProductMedia::whereIn('product_id', $cheap_food_id)->get()->toArray();

            $data['product']['cheap_food'] = array_reduce($data['product']['cheap_food'], function (array $accumulator, array $element) {
                $accumulator[$element['id']] = $element;

                return $accumulator;
            }, []);

            foreach ($media as $m) {
                if (!isset($data['product']['cheap_food'][$m['product_id']]['media'])) $data['product']['cheap_food'][$m['product_id']]['media'] = [];
                $data['product']['cheap_food'][$m['product_id']]['media'][] = $m;
            }
            
            $data['product']['cheap_food'] = array_values($data['product']['cheap_food']);
            
            // product.food_waste
            $data['product']['food_waste'] = Product::select(
                "products.id",
                "products.store_id",
                "products.title",
                "products.description",
                "products.stock",
                "products.is_new",
                "products.is_food",
                "products.is_active",
                "products.price",
                "products.expired_at",
                "products.likes",
                "stores.storename",
                "stores.name",
                "stores.province",
                "stores.latitude",
                "stores.longitude"
            );

            if (!empty($data['address']['latitude']) && !empty($data['address']['longitude'])) {
                $data['product']['food_waste'] = $data['product']['food_waste']
                ->selectRaw('
                    (
                        6371 * 1000 * acos(
                            cos(radians(?))
                            * cos(radians(stores.latitude)) 
                            * cos(radians(stores.longitude) - radians(?)) 
                            + sin(radians(?)) * sin(radians(stores.latitude))
                        )
                    ) AS distance', 
                    [
                        $data['address']['latitude'],
                        $data['address']['longitude'],
                        $data['address']['latitude']
                    ]
                );
            } 
            
            $data['product']['food_waste'] = $data['product']['food_waste']
            ->join('stores', 'products.store_id', '=', 'stores.id');

            if (
                empty($data['address']['latitude']) &&
                empty($data['address']['longitude']) &&
                !empty($data['address']['province'])
            ) {
                $data['product']['food_waste'] = $data['product']['food_waste']
                ->where('stores.province', '=', $data['address']['province']);
            }

            $data['product']['food_waste'] = $data['product']['food_waste']->where([
                ['products.stock', '>', 0],
                ['products.is_food', '=', true],
            ])
            ->where(function($query) use ($today) {
                $query->where('products.expired_at', '<', $today)
                ->orWhereNull('products.expired_at');
            });
            
            if (!empty($data['address']['latitude']) && !empty($data['address']['longitude'])) {
                $data['product']['food_waste'] = $data['product']['food_waste']->orderBy('distance');
            }

            $data['product']['food_waste'] = $data['product']['food_waste']->orderBy('products.created_at', 'desc');
            $data['product']['food_waste'] = $data['product']['food_waste']->limit(10);
            $data['product']['food_waste'] = $data['product']['food_waste']->get()->toArray();


            $food_waste_id = array_column($data['product']['food_waste'], 'id');
            $media = ProductMedia::whereIn('product_id', $food_waste_id)->get()->toArray();

            $data['product']['food_waste'] = array_reduce($data['product']['food_waste'], function (array $accumulator, array $element) {
                $accumulator[$element['id']] = $element;

                return $accumulator;
            }, []);

            foreach ($media as $m) {
                if (!isset($data['product']['food_waste'][$m['product_id']]['media'])) $data['product']['food_waste'][$m['product_id']]['media'] = [];
                $data['product']['food_waste'][$m['product_id']]['media'][] = $m;
            }
            
            $data['product']['food_waste'] = array_values($data['product']['food_waste']);
            
            // product.processed_waste
            $data['product']['processed_waste'] = Product::select(
                "products.id",
                "products.store_id",
                "products.title",
                "products.description",
                "products.stock",
                "products.is_new",
                "products.is_food",
                "products.is_active",
                "products.price",
                "products.expired_at",
                "products.likes",
                "stores.storename",
                "stores.name",
                "stores.province",
                "stores.latitude",
                "stores.longitude"
            );

            if (!empty($data['address']['latitude']) && !empty($data['address']['longitude'])) {
                $data['product']['processed_waste'] = $data['product']['processed_waste']
                ->selectRaw('
                    (
                        6371 * 1000 * acos(
                            cos(radians(?))
                            * cos(radians(stores.latitude)) 
                            * cos(radians(stores.longitude) - radians(?)) 
                            + sin(radians(?)) * sin(radians(stores.latitude))
                        )
                    ) AS distance', 
                    [
                        $data['address']['latitude'],
                        $data['address']['longitude'],
                        $data['address']['latitude']
                    ]
                );
            } 
            
            $data['product']['processed_waste'] = $data['product']['processed_waste']
            ->join('stores', 'products.store_id', '=', 'stores.id');

            if (
                empty($data['address']['latitude']) &&
                empty($data['address']['longitude']) &&
                !empty($data['address']['province'])
            ) {
                $data['product']['processed_waste'] = $data['product']['processed_waste']
                ->where('stores.province', '=', $data['address']['province']);
            }

            $data['product']['processed_waste'] = $data['product']['processed_waste']->where([
                ['products.stock', '>', 0],
                ['products.is_new', '=', true],
                ['products.is_food', '=', false],
            ]);
            
            if (!empty($data['address']['latitude']) && !empty($data['address']['longitude'])) {
                $data['product']['processed_waste'] = $data['product']['processed_waste']->orderBy('distance');
            }

            $data['product']['processed_waste'] = $data['product']['processed_waste']->orderBy('products.created_at', 'desc');
            $data['product']['processed_waste'] = $data['product']['processed_waste']->limit(10);
            $data['product']['processed_waste'] = $data['product']['processed_waste']->get()->toArray();

            $processed_waste_id = array_column($data['product']['processed_waste'], 'id');
            $media = ProductMedia::whereIn('product_id', $processed_waste_id)->get()->toArray();

            $data['product']['processed_waste'] = array_reduce($data['product']['processed_waste'], function (array $accumulator, array $element) {
                $accumulator[$element['id']] = $element;

                return $accumulator;
            }, []);

            foreach ($media as $m) {
                if (!isset($data['product']['processed_waste'][$m['product_id']]['media'])) $data['product']['processed_waste'][$m['product_id']]['media'] = [];
                $data['product']['processed_waste'][$m['product_id']]['media'][] = $m;
            }
            
            $data['product']['processed_waste'] = array_values($data['product']['processed_waste']);

            return Inertia::render('Home', [
                'canLogin' => Route::has('login'),
                'canRegister' => Route::has('register'),
                'data' => $data
            ]);
        } catch (Exception $e) {
            throw new WebException($e->getMessage(), 500);
        }
    }
}
