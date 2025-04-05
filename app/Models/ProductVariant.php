<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'sku',
        'price',
        'stock',
        'price_old'
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function images()
    {
        return $this->hasMany(Images::class, 'product_variant_id','id');
    }
    public function variantAttributes()
    {
        return $this->hasMany(VariantAttribute::class);
    }


}
