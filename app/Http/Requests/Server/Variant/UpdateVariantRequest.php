<?php

namespace App\Http\Requests\Server\Variant;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVariantRequest extends FormRequest
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
        $id = $this->route('variant'); // dùng khi update
        return [
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'publish'     => 'required|integer|in:0,1',
            'sanpham_id'  => 'nullable|exists:sanpham,id',
            'soluong'     => 'required|integer|min:0',
            'giaban'      => 'nullable|numeric|min:0',
            'hinhanh'     => 'nullable|string',
            'sku'         => 'nullable|string|max:50|unique:variants,sku,' . $id,
            'trangthai'   => 'nullable|integer|in:0,1',
        ];
    }
    public function messages()
    {
        return [
            'name.required'       => 'Tên biến thể không được để trống.',
            'name.string'         => 'Tên biến thể phải là chuỗi.',
            'name.max'            => 'Tên biến thể không được vượt quá 255 ký tự.',
            'publish.required'    => 'Vui lòng chọn trạng thái hiển thị.',
            'publish.in'          => 'Trạng thái hiển thị không hợp lệ.',
            'sanpham_id.exists'   => 'Sản phẩm không tồn tại.',
            'soluong.required'    => 'Số lượng không được để trống.',
            'soluong.integer'     => 'Số lượng phải là số nguyên.',
            'soluong.min'         => 'Số lượng phải lớn hơn hoặc bằng 0.',
            'giaban.numeric'      => 'Giá bán phải là số.',
            'giaban.min'          => 'Giá bán không được nhỏ hơn 0.',
            'sku.unique'          => 'SKU đã tồn tại.',
            'sku.max'             => 'SKU không được vượt quá 50 ký tự.',
            'trangthai.integer'   => 'Trạng thái không hợp lệ.',
            'trangthai.in'        => 'Trạng thái chỉ nhận giá trị 0 hoặc 1.',
        ];
    }
}
