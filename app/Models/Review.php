<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user-id',
        'product_id',
        'product_variant_id',
        'rating',
        'image',
        'content',
    ];
}
