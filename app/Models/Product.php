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
        return $this->variants->where('is_active', 1)->sum('stock');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function firstImage()
    {
        return $this->hasOne(Images::class)->orderBy('created_at', 'asc');
    }
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'product_id');
    }

}
