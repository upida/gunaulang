<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoinHistoryDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'coin_history_id',
        'type',
        'title',
        'value',
    ];
}
