<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest{
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
            'name.required' => 'Tên danh mục không được để trống',
            'name.max' => 'Tên danh mục không được vượt quá 225 ký tự',
            
        ];
        }
}

?>

