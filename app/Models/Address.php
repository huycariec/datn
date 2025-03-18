<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'user_addresses';
    protected $fillable = ['user_id', 'province_id', 'district_id', 'ward_id', 'address_detail'];

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function province() {
        return $this->belongsTo(Province::class);
    }
    public function district() {
        return $this->belongsTo(District::class);
    }
    public function ward() {
        return $this->belongsTo(Ward::class);
    }
}
