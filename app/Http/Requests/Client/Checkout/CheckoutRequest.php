<?php

namespace App\Http\Requests\Client\Checkout;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class CheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2|max:100',
            'sdtnhan' => [
                'required',
                'regex:/^(0|\+84)[0-9]{9,10}$/'
            ],
            'email' => 'required|email|max:255',
            'province_code' => 'required',
            'ward_code' => 'required',
            'phuongthuc_thanhtoan' => 'required|in:cod,bank',
            'address' => 'required|string',
            'note' => 'nullable|string|max:500',
            'cart_ids' => 'required|array|min:1',
            'cart_ids.*' => 'required|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập họ tên',
            'name.min' => 'Họ tên quá ngắn',
            'sdtnhan.required' => 'Vui lòng nhập số điện thoại',
            'sdtnhan.regex' => 'Số điện thoại không hợp lệ',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng',
            'province_code.required' => 'Chọn tỉnh',
            'ward_code.required' => 'Chọn xã/phường',
            'phuongthuc_thanhtoan.required' => 'Vui lòng chọn phương thức thanh toán',
            'address.required' => 'Vui lòng nhập địa chỉ nhận hàng',
            'address.string'   => 'Địa chỉ không hợp lệ',
            'cart_ids.required' => 'Giỏ hàng trống',
        ];
    }
}
