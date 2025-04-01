<?php

namespace App\Http\Controllers;

use App\Models\Ward;
use App\Models\District;
use App\Models\Province;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function getProvinces()
    {
        return response()->json(Province::all());
    }

    public function getDistricts($province_id)
    {
        return response()->json(District::where('province_id', $province_id)->get());
    }

    public function getWards($district_id)
    {
        return response()->json(Ward::where('district_id', $district_id)->get());
    }
}
