<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Images;


class Product extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'name', 'description','short_description', 'price', 'view', 'is_active','price_old'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function images()
    {
        return $this->hasMany(Images::class, 'product_id')->whereNull('product_variant_id');
    }
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
    public function wishlistedByUsers()
    {
        return $this->hasMany(Wishlist::class, 'product_id');
    }
    public function getTotalQuantityAttribute()
    {
        // Tính tổng số lượng của tất cả biến thể của sản phẩm
        return $this->variants->sum('stock');
    }
}