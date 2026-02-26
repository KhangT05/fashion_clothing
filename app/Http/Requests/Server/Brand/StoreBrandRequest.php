<?php

namespace App\Http\Requests\Server\Brand;

use Illuminate\Foundation\Http\FormRequest;

class StoreBrandRequest extends FormRequest
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
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'publish'     => 'required|integer|in:0,1',
            'hinhanh'     => 'nullable|string',
            'trangthai'   => 'nullable|integer|in:0,1',
        ];
    }
    public function messages()
    {
        return [
            'name.required'    => 'Tên thương hiệu không được để trống.',
            'name.string'      => 'Tên thương hiệu phải là chuỗi ký tự.',
            'name.max'         => 'Tên thương hiệu không được vượt quá 255 ký tự.',
            'publish.required' => 'Vui lòng chọn trạng thái hiển thị.',
            'publish.integer'  => 'Trạng thái hiển thị không hợp lệ.',
            'publish.in'       => 'Trạng thái hiển thị chỉ nhận giá trị 0 hoặc 1.',
            'hinhanh.string'   => 'Hình ảnh không hợp lệ.',
            'trangthai.integer' => 'Trạng thái không hợp lệ.',
            'trangthai.in'     => 'Trạng thái chỉ nhận giá trị 0 hoặc 1.',
        ];
    }
}
