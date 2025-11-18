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
        'electric_price',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
