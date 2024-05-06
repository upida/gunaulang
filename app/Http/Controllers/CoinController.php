<?php

namespace App\Http\Controllers;

use App\Exceptions\WebException;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Route;

class CoinController extends Controller
{
    public function coin(Request $request) {
        try {
            return Inertia::render('Coin/Index', [
                'canLogin' => Route::has('login'),
                'canRegister' => Route::has('register'),
            ]);
        } catch (Exception $e) {
            throw new WebException($e->getMessage(), 500);
        }
    }

    public function history(Request $request) {
        try {
            return Inertia::render('Coin/History', [
                'canLogin' => Route::has('login'),
                'canRegister' => Route::has('register'),
            ]);
        } catch (Exception $e) {
            throw new WebException($e->getMessage(), 500);
        }
    }

    public function history_detail(Request $request, int $id) {
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
