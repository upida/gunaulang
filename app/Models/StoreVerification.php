<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreVerification extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'full_name',
        'address',
        'subdistrict',
        'district',
        'city',
        'province',
        'postal_code',
        'ktp_number',
        'ktp_photo',
        'npwp_number',
        'npwp_photo',
    ];
}
