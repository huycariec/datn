<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(){
        $rules = [
            'name' => 'required|string|max:225',
        ];

        return $rules;
    }  

    public function messages()
    {
        return [
            'name.required' => 'Tên không được để trống',
            'name.max' => 'Tên không được vượt quá 225 ký tự',
            
        ];
        }
}

?>

