<?php

namespace App\Http\Controllers;

use App\Exceptions\WebException;
use App\Models\Coin;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Route;

class CoinController extends Controller
{
    public function coin(Request $request) {
        try {
            $user = $request->user();

            $coin = Coin::where('user_id', '=', $user->id)->first();
            if (!$coin) $coin = Coin::create([
                'user_id' => $user->id,
                'balance' => 0,
            ]);

            return Inertia::render('Coin/Index', [
                'canLogin' => Route::has('login'),
                'canRegister' => Route::has('register'),
                'data' => [
                    'coin' => $coin
                ]
            ]);
        } catch (Exception $e) {
            throw new WebException($e->getMessage(), 500);
        }
    }

    public function history(Request $request) {
        try {
            return Inertia::render('Coin/History/Index', [
                'canLogin' => Route::has('login'),
                'canRegister' => Route::has('register'),
            ]);
        } catch (Exception $e) {
            throw new WebException($e->getMessage(), 500);
        }
    }

    public function history_detail(Request $request, $id) {
        try {
            return Inertia::render('Coun/History/Detail', [
                'canLogin' => Route::has('login'),
                'canRegister' => Route::has('register'),
            ]);
        } catch (Exception $e) {
            throw new WebException($e->getMessage(), 500);
        }
    }
}
