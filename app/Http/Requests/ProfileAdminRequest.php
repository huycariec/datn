<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileAdminRequest extends FormRequest{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(){
        $rules = [
            'name' => 'required|string|max:225',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone' => 'required|string|max:10',
            'dob' => 'date',

        ];

        return $rules;
    }  

    public function messages()
    {
        return [
            'name.required' => 'Tên không được để trống',
            'name.max' => 'Tên không được vượt quá 225 ký tự',
            'avatar.image' => 'Phải là định dạng ảnh',
            'avatar.mimes' => 'Không đúng định dạng ảnh',
            'avatar.max' => 'Định dạng ảnh quá lớn',
            'phone.required' => 'Số điện thoại không được để trống',
            'phone.max' => 'Số điện thoại không đúng định dạng',
            'dob.date' => 'Ngày sinh không đúng định dạng',
            
        ];
        }
}

?>

