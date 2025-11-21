<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;
        
    protected $fillable = [
        'id',
        'invoice_date',
        'block_id',
        'customer_id',
        'from_date',
        'to_date',
        'house_price',
        'garbage_price',
        'old_water_number',
        'new_water_number',
        'total_used_water',
        'old_electric_number',
        'new_electric_number',
        'total_used_electric',
        'water_unit_price',
        'total_amount_water',
        'electric_unit_price',
        'total_amount_electric',
        'total_amount_usd',
        'total_amount_khr',
    ];
    
    public function block()
    {
        return $this->belongsTo(Block::class);
    }
    
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
