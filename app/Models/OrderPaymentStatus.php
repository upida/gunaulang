<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPaymentStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'order_payment_id',
        'title',
        'description',
        'received',
    ];
}
