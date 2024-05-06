<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'title',
        'description',
        'stock',
        'is_new',
        'is_food',
        'is_active',
        'price',
        'expired_at',
        'likes',
    ];
}
