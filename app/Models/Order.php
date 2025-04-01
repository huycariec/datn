<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'shipper_id',
        'total_amount',
        'status',
        'shipping_status',
        'payment_method',
        'shipping_fee',
        'province_id',
        'district_id',
        'ward_id'
    ];

    protected $casts = [
        'status' => OrderStatus::class,
        'payment_method' => PaymentMethod::class
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
