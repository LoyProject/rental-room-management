<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    protected $fillable = [
        'id',
        'site_id',
        'name',
        'description',
        'water_price',
        'electric_price',
        'status',
    ];
}
