<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingFee extends Model
{
    use HasFactory;
    protected $table = 'shipping_fees';
    protected $fillable = ['province_id', 'district_id', 'fee', 'is_free'];

    // Quan hệ với Province
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    // Quan hệ với District
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }
}
