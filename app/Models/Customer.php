<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;
    
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
