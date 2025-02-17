<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DiscountRequest extends FormRequest
{
    /**
     * Xác định người dùng có được phép gửi request này không.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Định nghĩa các rule validate.
     */
    public function rules(): array
    {
        $rules = [
            'code' => 'required|string|max:255|unique:discounts,code',
            'value' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'min_order_amount' => 'required|integer|min:0',
            'max_discount_value' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
            'quantity' => 'required|integer|min:1',
        ];

        if ($this->input('type') === 'percent') {
            $rules['value'] = 'required|numeric|min:0|max:100';
        }

        return $rules;
    }


    /**
     * Định nghĩa thông báo lỗi.
     */
    public function messages(): array
    {
        return [
            'code.required'         => 'Mã giảm giá không được để trống.',
            'code.unique'           => 'Mã giảm giá đã tồn tại.',
            'value.required'        => 'Giá trị giảm giá không được để trống.',
            'value.numeric'         => 'Giá trị giảm giá phải là số.',
            'start_date.required'   => 'Ngày bắt đầu không được để trống.',
            'end_date.required'     => 'Ngày kết thúc không được để trống.',
            'end_date.after'        => 'Ngày kết thúc phải sau ngày bắt đầu.',
            'min_order_amount.required' => 'Số tiền tối thiểu không được để trống.',
            'max_discount_value.required' => 'Số tiền tối đa không được để trống.',
            'quantity.required'     => 'Số lượng không được để trống.',
            'quantity.integer'      => 'Số lượng phải là số nguyên.',
            'type.required'         => 'Loại giảm giá không được để trống.',
            'status.required'       => 'Trạng thái không được để trống.',
            'status.in'             => 'Trạng thái phải là "active" hoặc "inactive".',
        ];
    }
}
