<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileAdminRequest;
use App\Models\Admin\Profile;
use App\Models\Profile as ModelsProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use WpOrg\Requests\Auth;

class ProfileController extends Controller
{

    public function profile(Request $request)
    {
        // $user = $request->user();
        $user = $request->user();
        $profile = $user->profile();
        return view('admin.pages.profile',compact('profile'));
    }

    public function updateProfile(ProfileAdminRequest $request) {
        $request->validate([
            'name' => 'required|string|max:225',
            'avatar'=>'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gender' => 'required',
            'phone' => 'required|string|max:10',
            'dob' => 'required|date',
            
        ]);
    
        $user = $request->user(); 
        $user->update($request->only(['name']));
    
        // Kiểm tra nếu profile chưa có thì tạo mới
        $profile = $user->profile ?? new ModelsProfile();
        if (!$profile->exists) {
            $profile->user_id = $user->id;
        }
    
        if ($request->hasFile('avatar')) {
            // Xóa ảnh cũ nếu có
            if ($profile->avatar) {
                Storage::delete('public/image/' . $profile->avatar);
            }
    
            // Lưu ảnh mới
            $avatarNew = time() . '.' . $request->avatar->extension();
            $request->avatar->storeAs('public/image', $avatarNew);
            $profile->avatar = $avatarNew;
        }
    
        // Cập nhật thông tin khác
        $profile->gender = $request->gender;
        $profile->phone = $request->phone;
        $profile->dob = $request->dob;
        $profile->role = '1';
        $profile->save();
    
        return redirect()->back()->with('success', 'Hồ sơ đã được cập nhật thành công!');
    }
    
    
   
}
