<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;
    protected $table = 'user_addresses';
    protected $fillable = [
        'user_id',
        'province_id',
        'district_id',
        'ward_id',
        'address_detail',
    ];

}
