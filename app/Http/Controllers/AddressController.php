<?php

namespace App\Http\Controllers;

use App\Exceptions\WebException;
use App\Models\UserAddress;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Redirect;
use Route;

class AddressController extends Controller
{
    public function address(Request $request) {
        try {
            $addresses = UserAddress::where('user_id', $request->user()->id)
            ->orderBy('id', 'desc')
            ->orderBy('is_active', 'desc')
            ->get()
            ->toArray();
            
            $active = [];
            if (isset($addresses[0]['is_active']) && $addresses[0]['is_active']) $active = $addresses[0];

            return Inertia::render('Profile/Address/Index', [
                'canLogin' => Route::has('login'),
                'canRegister' => Route::has('register'),
                'data' => [
                    'active' => $active,
                    'address' => $addresses
                ]
            ]);
        } catch (Exception $e) {
            throw new WebException($e->getMessage(), 500);
        }
    }

    public function create_page(Request $request) {
        try {
            return Inertia::render('Profile/Address/Create', [
                'canLogin' => Route::has('login'),
                'canRegister' => Route::has('register'),
            ]);
        } catch (Exception $e) {
            throw new WebException($e->getMessage(), 500);
        }
    }

    public function create(Request $request) {
        try {
            $user = $request->user();

            $request->validate([
                'is_active' => 'required|boolean',
                'name' => 'required|string|max:20',
                'phone' => 'required|string|regex:/^[a-z0-9_-]{3,15}$/',
                'address' => 'required|string|max:100',
                'subdistrict' => 'required|string|max:50',
                'district' => 'required|string|max:50',
                'city' => 'required|string|max:20',
                'province' => 'required|string|max:20',
                'latitude' => 'nullable|string|max:20',
                'longitude' => 'nullable|string|max:20',
                'gmaps_point' => 'nullable|string|max:20',
                'notes' => 'nullable|string|max:50',
            ],[
                'phone.regex' => 'The phone field format starts with 0. The length is 9 to 13 characters.'
            ]);

            UserAddress::create([
                'user_id' => $user->id,
                'is_active' => $request->get('is_active'),
                'name' => $request->get('name'),
                'phone' => $request->get('phone'),
                'address' => $request->get('address'),
                'subdistrict' => $request->get('subdistrict'),
                'district' => $request->get('district'),
                'city' => $request->get('city'),
                'province' => $request->get('province'),
                'latitude' => $request->get('latitude'),
                'longitude' => $request->get('longitude'),
                'gmaps_point' => $request->get('gmaps_point'),
                'notes' => $request->get('notes'),
            ]);

            return Redirect::to('/profile/address');
        } catch (Exception $e) {
            throw new WebException($e->getMessage(), 500);
        }
    }
    
    public function edit(Request $request, int $id) {
        try {
            $address = UserAddress::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->first();
    
            if (!$address) throw new WebException("Address not found", 404);
            
            return Inertia::render('Address/Edit', [
                'canLogin' => Route::has('login'),
                'canRegister' => Route::has('register'),
                'data' => [
                    'address' => $address
                ]
            ]);
        } catch (Exception $e) {
            throw new WebException($e->getMessage(), 500);
        }
    }
}
