<?php

namespace App\Http\Controllers;

use App\Exceptions\WebException;
use App\Models\Product;
use App\Models\UserAddress;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Route;

class SearchController extends Controller
{
    public function search(Request $request) {
        try {
            $user = $request->user();

            $is_new = $request->get('is_new');
            $is_food = $request->get('is_food');
            $price_sign = $request->get('price_sign');
            $expired_at_sign = $request->get('expired_at_sign');

            $address = [];
            if ($user) {
                $address = UserAddress::where([
                    'user_id' => $user->id,
                    'is_active' => true
                ])
                ->first();
            }

            $today = date('Y-m-d');

            $product = Product::select('products.*')
            ->select('stores.*');

            if ($user && !empty($address->latitude) && !empty($address->longitude)) {
                $product = $product
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
                        $address->latitude,
                        $address->longitude,
                        $address->latitude
                    ]
                );
            }

            $product = $product->join('stores', 'products.store_id', '=', 'stores.id');
            
            if ($user && empty($address->latitude) && empty($address->longitude) && !empty($address->province)) {
                $product = $product
                ->where('stores.province', '=', $address->province);
            }

            # free food : is_new true, is_food true, price 0, expired_at >= today
            # cheap food : is_new true, is_food true, price > 0, expired_at >= today
            # food waste : is_food true, expired_at < today
            # processed waste : is_new true, is_food false

            $where = [];
            if ($is_new) $where[] = ['products.is_new', '=', $is_new];
            if ($is_food) $where[] = ['products.is_food', '=', $is_food];
            if ($price_sign) $where[] = ['products.price', $price_sign, 0];
            if ($expired_at_sign) $where[] = ['products.expired_at', $expired_at_sign, $today];

            $product = $product->where(array_merge([
                ['products.is_active', '=', true],
                ['products.stock', '>', 0],
            ], $where));

            if ($user && !empty($address->latitude) && !empty($address->longitude)) {
                $product = $product->orderBy('distance');
            }

            $product = $product->orderBy('products.created_at', 'desc');
            $product = $product->get()->toArray();

            return Inertia::render('Search', [
                'canLogin' => Route::has('login'),
                'canRegister' => Route::has('register'),
                'data' => [
                    'product' => $product
                ]
            ]);
        } catch (Exception $e) {
            throw new WebException($e->getMessage(), 500);
        }
    }
}
