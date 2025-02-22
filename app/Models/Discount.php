<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'value',
        'start_date',
        'end_date',
        'max_discount_value',
        'min_order_amount',
        'quantity',
        'type',
        'use_for',
    ];
}
