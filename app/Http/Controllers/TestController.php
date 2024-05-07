<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function csrf() {
        return response()->json([
            'token' => csrf_token()
        ]);
    }
}
