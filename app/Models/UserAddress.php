<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'is_active',
        'name',
        'phone',
        'address',
        'subdistrict',
        'district',
        'city',
        'province',
        'latitude',
        'longitude',
        'gmaps_point',
        'notes',
    ];
}
