<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'store_id',
        'order_id',
        'product_id',
        'parent_id',
        'product_title',
        'variant_id',
        'variant_name',
        'rate',
        'description',
        'total_positive_reaction',
        'total_negative_reaction',
    ];
}
