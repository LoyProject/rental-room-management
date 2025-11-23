<?php

namespace App\Models;

use App\Models\Block;
use App\Models\Site;
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
        'garbage_price',
        'old_water_number',
        'old_electric_number',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function block()
    {
        return $this->belongsTo(Block::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
