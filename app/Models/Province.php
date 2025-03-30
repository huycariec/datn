<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $fillable = [
        'name'
    ];
    public function districts() {
        return $this->hasMany(District::class);
    }
    public function shippingFees()
    {
        return $this->hasMany(ShippingFee::class, 'province_id');
    }

}
