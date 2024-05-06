<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'storename',
        'name',
        'description',
        'logo',
        'cover',
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
