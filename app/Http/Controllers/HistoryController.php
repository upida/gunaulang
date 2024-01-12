<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Route;

class HistoryController extends Controller
{
    public function page(Request $request)
    {
        return Inertia::render('History', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register')
        ]);
    }
}
