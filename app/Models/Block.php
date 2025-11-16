<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Block extends Model
{
    use HasFactory;

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
