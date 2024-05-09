<?php

namespace App\Http\Controllers;

use App\Exceptions\WebException;
use App\Models\Product;
use App\Models\ProductMedia;
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
            $price_start = $request->get('price_start');
            $price_end = $request->get('price_end');
            $expired_at_start = $request->get('expired_at_start');
            $expired_at_end = $request->get('expired_at_end');
            $keyword = $request->get('keyword');

            $address = [];
            if ($user) {
                $address = UserAddress::where([
                    'user_id' => $user->id,
                    'is_active' => true
                ])
                ->first();
            }

            // $today = date('Y-m-d');

            $product = Product::select(
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
            
            if ($price_start) $where[] = ['products.price', '>=', $price_start];

            if ($price_end) $where[] = ['products.price', '<=', $price_end];
            
            if ($expired_at_start) $where[] = ['products.expired_start', '>=', $expired_at_start];

            if ($expired_at_end) $where[] = ['products.expired_end', '<=', $expired_at_end];

            $product = $product->where(array_merge([
                ['products.is_active', '=', true],
                ['products.stock', '>', 0],
            ], $where));

            if ($keyword) $product = $product->whereAny(['products.title', 'products.description'], 'LIKE', "%" . $keyword . "%");

            if ($user && !empty($address->latitude) && !empty($address->longitude)) {
                $product = $product->orderBy('distance');
            }

            $product = $product->orderBy('products.created_at', 'desc');
            $product = $product->get()->toArray();

            $product_batch = array_chunk($product, 10);

            foreach ($product_batch as $batch_key => $batch) {
                $batch_id = array_column($batch, 'id');
                $media = ProductMedia::whereIn('product_id', $batch_id)->get()->toArray();

                $batch = array_reduce($batch, function (array $accumulator, array $element) {
                    $accumulator[$element['id']] = $element;

                    return $accumulator;
                }, []);

                foreach ($media as $m) {
                    if (!isset($batch[$m['product_id']]['media'])) $batch[$m['product_id']]['media'] = [];
                    $batch[$m['product_id']]['media'][] = $m;
                }

                $product_batch[$batch_key] = $batch;
            }

            $product = array_merge(...$product_batch);

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
