<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileAdminRequest;
use App\Models\Admin\Profile;
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
            'avatar'=>'image|mimes:jpeg,png,jpg,gif|max:2048',
            // 'gender' => 'nullable',
            'phone' => 'required|string|max:10',
            'dob' => 'date',
        ]);
        $user = $request->user(); 
        $user->update($request->only(['name']));

        $profile = $user->profile;

        if ($request->hasFile('avatar')) {
            // Xóa ảnh cũ nếu có
            if ($profile->avatar) {
                Storage::delete('public/image/' . $profile->avatar);
            }
    
            // Lưu ảnh mới
            $avatarNew = time() . '.' . $request->avatar->extension();
            $request->avatar->storeAs('public/image', $avatarNew);
            // dd($avatarNew);
            $profile->avatar = $avatarNew;
        }

        $profile->gender = $request->gender;
        $profile->phone = $request->phone;
        $profile->dob = $request->dob;
        $profile->save();


        return redirect()->back()->with('success', 'Hồ sơ đã được cập nhật thành công!');
    }
    
   
}
