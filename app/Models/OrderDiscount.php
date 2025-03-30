<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDiscount extends Model
{
    use HasFactory;
    protected $fillable=[
        'discount_id',
        'order_id',
        'discount_value',
        
    ];
}
