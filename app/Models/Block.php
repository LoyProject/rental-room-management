<?php

namespace App\Models;

use App\Models\Site;
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
        'electric_source',
        'electric_price',
        'max_electric_price',
        'calculation_threshold',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
