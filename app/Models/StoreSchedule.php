<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'day',
        'start',
        'end',
        'is_open',
    ];
}
