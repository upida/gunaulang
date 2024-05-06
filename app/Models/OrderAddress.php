<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
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
