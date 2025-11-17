<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'id',
        'block_id',
        'name',
        'phone',
        'house_price',
        'wifi_price',
        'garbage_price',
        'old_water_bill',
        'old_electric_bill',
    ];
}
