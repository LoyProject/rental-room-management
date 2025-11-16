<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Block extends Authenticatable
{
    use HasFactory, Notifiable;

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
