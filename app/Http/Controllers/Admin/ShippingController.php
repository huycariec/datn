<?php

namespace App\Http\Controllers\Admin;

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
use App\Models\ShippingFee;


class ShippingController extends Controller
{

    public function addAddressForm()
    {
        $provinces = Province::all();
        return view('admin.pages.adrees.add-address', compact('provinces'));
    }


    public function listShippingFees()
{
    $shippingFees = ShippingFee::with('province', 'district', 'ward')->paginate(10);
    return view('admin.pages.adrees.list-shipping-fees', compact('shippingFees'));
}


public function addAddress(Request $request)
{
    try {
        $rules = [
            'province_id' => 'required',
            'district_id' => 'required',
            'ward_id' => 'required',
            'fee' => 'required|numeric',
        ];

        $messages = [
            'province_id.required' => 'Vui lòng chọn tỉnh/thành phố.',
            'district_id.required' => 'Vui lòng chọn quận/huyện.',
            'ward_id.required' => 'Vui lòng chọn phường/xã.',
            'fee.required' => 'Vui lòng nhập giá tiền vận chuyển.',
            'fee.numeric' => 'Giá tiền vận chuyển phải là số.',
        ];

        $validated = $request->validate($rules, $messages);

        // ✅ Kiểm tra trùng Tỉnh + Quận + Xã đã tồn tại chưa
        $exists = ShippingFee::where('province_id', $validated['province_id'])
            ->where('district_id', $validated['district_id'])
            ->where('ward_id', $validated['ward_id'])
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['ward_id' => 'Phí vận chuyển cho khu vực này đã tồn tại.']);
        }

        ShippingFee::create([
            'province_id' => $validated['province_id'],
            'district_id' => $validated['district_id'],
            'ward_id' => $validated['ward_id'],
            'fee' => $validated['fee'],
        ]);

        return redirect()->route('admin.addAddressForm')->with('success', 'Thêm phí vận chuyển thành công!');
    } catch (\Exception $exception) {
        return redirect()->route('admin.addAddressForm')->with('error', $exception->getMessage());
    }
}
public function editAddressForm($id)
{
    $shippingFee = ShippingFee::findOrFail($id);  // Lấy phí vận chuyển theo ID
    $provinces = Province::all();  // Lấy danh sách các tỉnh
    $districts = District::where('province_id', $shippingFee->province_id)->get();  // Lấy các quận huyện theo tỉnh
    $wards = Ward::where('district_id', $shippingFee->district_id)->get();  // Lấy các phường xã theo quận

    return view('admin.pages.adrees.edit-address', compact('shippingFee', 'provinces', 'districts', 'wards'));
}


// Cập nhật phí vận chuyển
public function updateAddress(Request $request, $id)
{
    try {
        $rules = [
            'province_id' => 'required',
            'district_id' => 'required',
            'ward_id' => 'required',
            'fee' => 'required|numeric',
        ];

        $messages = [
            'province_id.required' => 'Vui lòng chọn tỉnh/thành phố.',
            'district_id.required' => 'Vui lòng chọn quận/huyện.',
            'ward_id.required' => 'Vui lòng chọn phường/xã.',
            'fee.required' => 'Vui lòng nhập giá tiền vận chuyển.',
            'fee.numeric' => 'Giá tiền vận chuyển phải là số.',
        ];

        $validated = $request->validate($rules, $messages);

        // ✅ Kiểm tra xem tổ hợp mới đã tồn tại trong DB chưa (ngoại trừ chính nó)
        $exists = ShippingFee::where('province_id', $validated['province_id'])
            ->where('district_id', $validated['district_id'])
            ->where('ward_id', $validated['ward_id'])
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['ward_id' => 'Phí vận chuyển cho khu vực này đã tồn tại.']);
        }

        $shippingFee = ShippingFee::findOrFail($id);
        $shippingFee->update([
            'province_id' => $validated['province_id'],
            'district_id' => $validated['district_id'],
            'ward_id' => $validated['ward_id'],
            'fee' => $validated['fee'],
        ]);

        return redirect()->route('admin.listShippingFees')->with('success', 'Cập nhật phí vận chuyển thành công!');
    } catch (\Exception $exception) {
        return redirect()->route('admin.listShippingFees')->with('error', $exception->getMessage());
    }
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

public function destroy($id)
{
    $shippingFee = ShippingFee::findOrFail($id);
    $shippingFee->delete();

    return redirect()->back()->with('success', 'Đã xoá phí vận chuyển thành công.');
}

}
