<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'product_variant_id',
        'rating',
        'image',
        'content',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function product() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function productVariant() {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id', 'id');
    }
}
