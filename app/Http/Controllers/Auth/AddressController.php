<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Models\Address;
use App\Models\District;
use App\Models\Profile;
use App\Models\Province;
use App\Models\UserAddress;
use App\Models\Ward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AddressController extends Controller
{
    public function showProfile()
    {
        $user = Auth::user();
        $profile = $user->profile;
        $addresses = $user->addresses;

        return view('client.profile', compact('user', 'profile', 'addresses'));
    }

    public function editProfile()
    {
        $user = Auth::user();
        $profile = $user->profile;

        return view('client.edit-profile', compact('user', 'profile'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $profile = $user->profile;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'nullable|in:0,1',
            'dob' => 'nullable|date|before:today',
            'phone' => 'nullable|string|max:15',
        ]);

        $user->update(['name' => $validated['name']]);

        if ($profile) {
            $profile->update($validated);
        } else {
            $user->profile()->create($validated);
        }

        return redirect()->route('client.profile')->with('success', 'Cập nhật hồ sơ thành công!');
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        $profile = $user->profile;

        if ($request->hasFile('avatar')) {
            if ($profile && $profile->avatar) {
                Storage::delete('public/' . $profile->avatar);
            }

            $path = $request->file('avatar')->store('avatars', 'public');

            if ($profile) {
                $profile->update(['avatar' => $path]);
            } else {
                $user->profile()->create(['avatar' => $path]);
            }
        }

        return redirect()->route('client.profile')->with('success', 'Cập nhật avatar thành công!');
    }

    public function addAddressForm()
    {
        $provinces = Province::all();
        return view('client.add-address', compact('provinces'));
    }

    public function getDistricts($province_id)
    {
        $districts = District::where('province_id', $province_id)->get();
        return response()->json($districts);
    }

    public function getWards($district_id)
    {
        $wards = Ward::where('district_id', $district_id)->get();
        return response()->json($wards);
    }

    public function addAddress(Request $request)
    {
        $validated = $request->validate([
            'province_id' => 'required',
            'district_id' => 'required',
            'ward_id' => 'required',
            'address_detail' => 'required|string',
        ]);

        $user = Auth::user();
        $validated['user_id'] = $user->id;
        UserAddress::create($validated);
        return redirect()->route('client.profile')->with('success', 'Thêm địa chỉ thành công!');
    }

    public function editAddress($id)
    {
        $address = Auth::user()->addresses()->findOrFail($id);
        return view('client.edit-address', compact('address'));
    }

    public function updateAddress(Request $request, $id)
    {
        $address = Auth::user()->addresses()->findOrFail($id);

        $validated = $request->validate([
            'province_name' => 'required|string',
            'district_name' => 'required|string',
            'ward_name' => 'required|string',
            'address' => 'required|string',
        ]);

        $address->update([
            'province_name' => $validated['province_name'],
            'district_name' => $validated['district_name'],
            'ward_name' => $validated['ward_name'],
            'address_detail' => $validated['address'],
        ]);

        return redirect()->route('client.profile')->with('success', 'Cập nhật địa chỉ thành công!');
    }

    public function deleteAddress($id)
    {
        $address = Auth::user()->addresses()->findOrFail($id);
        $address->delete();

        return redirect()->route('client.profile')->with('success', 'Xóa địa chỉ thành công!');
    }
}
