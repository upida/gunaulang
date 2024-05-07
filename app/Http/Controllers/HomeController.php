<?php

namespace App\Http\Controllers;

use App\Exceptions\WebException;
use App\Models\Product;
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
            $data['product']['free_food'] = Product::select('products.*')
            ->select('stores.*');

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

            // product.cheap_food
            $data['product']['cheap_food'] = Product::select('products.*')
            ->select('stores.*');

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
            
            // product.food_waste
            $data['product']['food_waste'] = Product::select('products.*')
            ->select('stores.*');

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
            
            // product.processed_waste
            $data['product']['processed_waste'] = Product::select('products.*')
            ->select('stores.*');

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
