<?php

namespace App\Http\Controllers;

use App\Exceptions\WebException;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Route;

class LikesController extends Controller
{
    public function likes(Request $request) {
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
