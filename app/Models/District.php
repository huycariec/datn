<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable = [
        'name',
        'province_id'
    ];
    public function province() {
        return $this->belongsTo(Province::class);
    }
    public function wards() {
        return $this->hasMany(Ward::class);
    }
    public function shippingFee()
    {
        return $this->hasOne(ShippingFee::class, 'district_id');
    }

}
