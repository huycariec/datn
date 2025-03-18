<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Models\Address;
use App\Models\District;
use App\Models\Profile;
use App\Models\Province;
use App\Models\Ward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function showProfile()
    {
        $user = auth()->user();
        $addresses = auth()->user()->addresses;
        $profile = Profile::where('user_id', $user->id)->first();
        return view('client.profile', compact('user', 'addresses', 'profile'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gender' => 'required|in:0,1',
            'dob' => 'nullable|date',
            'phone' => ['nullable', 'string', 'max:10', 'regex:/^(\+84|0)[1-9][0-9]{8}$/u'],
        ], [
            'name.required' => 'Tên không được để trống.',
            'name.string' => 'Tên phải là chuỗi ký tự.',
            'name.max' => 'Tên không được vượt quá 255 ký tự.',
            'avatar.image' => 'Avatar phải là hình ảnh.',
            'avatar.mimes' => 'Avatar phải có định dạng jpeg, png, jpg hoặc gif.',
            'avatar.max' => 'Avatar không được vượt quá 2MB.',
            'gender.required' => 'Giới tính không được để trống.',
            'gender.in' => 'Giới tính không hợp lệ.',
            'dob.date' => 'Ngày sinh không hợp lệ.',
            'phone.max' => 'Số điện thoại không được vượt quá 10 ký tự.',
            'phone.regex' => 'Số điện thoại không đúng định dạng Việt Nam.',
        ]);

        $user = auth()->user();
        $user->name = $request->name;

        $profile = Profile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'gender' => $request->gender,
                'dob' => $request->dob,
                'phone' => $request->phone,
                'avatar' => $request->hasFile('avatar') ? $request->file('avatar')->store('avatars', 'public') : $user->profile->avatar ?? null
            ]
        );

        $user->save();
        return redirect()->route('client.profile')->with('success', 'Hồ sơ đã được cập nhật.');
    }

    public function addAddress(Request $request)
    {
        $request->validate([
            'province_name' => 'required|string|max:255',
            'district_name' => 'required|string|max:255',
            'ward_name' => 'required|string|max:255',
            'address' => 'required|string|max:255|min:10',
        ], [
            'province_name.required' => 'Tỉnh/Thành phố không được để trống.',
            'province_name.string' => 'Tỉnh/Thành phố phải là chuỗi ký tự.',
            'province_name.max' => 'Tỉnh/Thành phố không được vượt quá 255 ký tự.',
            'district_name.required' => 'Quận/Huyện không được để trống.',
            'district_name.string' => 'Quận/Huyện phải là chuỗi ký tự.',
            'district_name.max' => 'Quận/Huyện không được vượt quá 255 ký tự.',
            'ward_name.required' => 'Phường/Xã không được để trống.',
            'ward_name.string' => 'Phường/Xã phải là chuỗi ký tự.',
            'ward_name.max' => 'Phường/Xã không được vượt quá 255 ký tự.',
            'address.required' => 'Địa chỉ chi tiết không được để trống.',
            'address.string' => 'Địa chỉ chi tiết phải là chuỗi ký tự.',
            'address.max' => 'Địa chỉ chi tiết không được vượt quá 255 ký tự.',
            'address.min' => 'Địa chỉ chi tiết phải có ít nhất 10 ký tự.',
        ]);

        // Luôn tạo mới tỉnh, huyện, xã mà không kiểm tra tồn tại trước
        $province = Province::create(['name' => $request->province_name]);
        $district = District::create(['name' => $request->district_name, 'province_id' => $province->id]);
        $ward = Ward::create(['name' => $request->ward_name, 'district_id' => $district->id]);

        // Tạo địa chỉ mới
        $address = new Address();
        $address->user_id = auth()->id();
        $address->province_id = $province->id;
        $address->district_id = $district->id;
        $address->ward_id = $ward->id;
        $address->address_detail = $request->address;
        $address->save();

        return redirect()->back()->with('success', 'Địa chỉ đã được tạo.');
    }

    public function updateAddress(Request $request, $id)
    {
        $request->validate([
            'province_name' => 'required|string|max:255',
            'district_name' => 'required|string|max:255',
            'ward_name' => 'required|string|max:255',
            'address' => 'required|string|max:255|min:10',
        ], [
            'province_name.required' => 'Tỉnh/Thành phố không được để trống.',
            'province_name.string' => 'Tỉnh/Thành phố phải là chuỗi ký tự.',
            'province_name.max' => 'Tỉnh/Thành phố không được vượt quá 255 ký tự.',
            'district_name.required' => 'Quận/Huyện không được để trống.',
            'district_name.string' => 'Quận/Huyện phải là chuỗi ký tự.',
            'district_name.max' => 'Quận/Huyện không được vượt quá 255 ký tự.',
            'ward_name.required' => 'Phường/Xã không được để trống.',
            'ward_name.string' => 'Phường/Xã phải là chuỗi ký tự.',
            'ward_name.max' => 'Phường/Xã không được vượt quá 255 ký tự.',
            'address.required' => 'Địa chỉ chi tiết không được để trống.',
            'address.string' => 'Địa chỉ chi tiết phải là chuỗi ký tự.',
            'address.max' => 'Địa chỉ chi tiết không được vượt quá 255 ký tự.',
            'address.min' => 'Địa chỉ chi tiết phải có ít nhất 10 ký tự.',
        ]);

        $address = Address::findOrFail($id);

        // Luôn tạo mới tỉnh, huyện, xã
        $province = Province::create(['name' => $request->province_name]);
        $district = District::create(['name' => $request->district_name, 'province_id' => $province->id]);
        $ward = Ward::create(['name' => $request->ward_name, 'district_id' => $district->id]);

        // Cập nhật địa chỉ
        $address->province_id = $province->id;
        $address->district_id = $district->id;
        $address->ward_id = $ward->id;
        $address->address_detail = $request->address;
        $address->save();

        return redirect()->back()->with('success', 'Địa chỉ đã được cập nhật.');
    }

    public function deleteAddress($id)
    {
        Address::destroy($id);
        return redirect()->back()->with('success', 'Địa chỉ đã được xóa.');
    }
}
